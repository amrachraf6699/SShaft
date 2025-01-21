<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewDonationForAdminNotify;
use App\Traits\SmsTrait;

class PaymentController extends Controller
{
    use SmsTrait;
    /***
     *
     * CREDIT CARD
     */
    public function viewCreditCard($donation_code, $payment_brand)
    {
        $donation = Donation::where('donation_code', '=', $donation_code)->first();
        if($donation && $donation->status == 'unpaid') {
            // PAYMENT PROVIDER
            if(request('id') && request('resourcePath')) {
                $payment_status = $this->getPaymentStatus(request('id'), request('resourcePath'));
                $result_code    = $payment_status['result']['code'];

                if (($result_code == '000.100.110' || $result_code == '000.000.000' || $result_code == '000.300.000') && isset($payment_status['merchantTransactionId']) && !empty($payment_status['merchantTransactionId'])) { // success payment id >> transaction bank id
                    $showSuccessPaymentMessage = true;
                    // update transaction in donation table with transaction id  = $payment_status['id]
                    $data = [
                        'bank_transaction_id'   => $payment_status['merchantTransactionId'],
                        'payment_brand'         => $payment_status['paymentBrand'],
                        'status'                => 'paid',
                        'payment_ways'          => 'credit_card',
                    ];
                    $donation->update($data);

                    // update "collected_value" in service
                    $services = $donation->services()->get();
                    foreach ($services as $service) {
                        $service->update([
                            'collected_value'  => $service->collected_value + $service->pivot->amount,
                        ]);
                    }

                    // Send sms
                    $route = route('donation-invoice.show', $donation->donation_code);
                    $this->sendSms($donation->donor->phone, __('messages.donation_completion_msg', ['invoice_link' => $route]));

                    User::each(function($admin, $key) use ($donation) {
                        $admin->notify(new NewDonationForAdminNotify($donation));
                    });

                    session()->flash('sessionSuccess', 'تمت العملية بنجاح، جعله الله عملاً خالصاً في ميزان حسناتكم!');
                    return redirect()->route('frontend.reviews.index', $donation->donation_code);
                } else {
                    session()->flash('sessionError', 'فشلت عملية الدفع، الرجاء التحقق وإعادة المحاولة!');
                    return redirect()->back();
                }
            }

            return view('frontend.donations.credit-card', compact('donation'));
        }
        abort('404');
    }

    public function storeCreditCard(Request $request, $donation_code)
    {
        $donation = Donation::where('donation_code', '=', $donation_code)->first();
        if($donation) {
            // validate
            $data = $request->validate([
                'payment_brand' => 'required|in:MADA,VISA',
                'name'          => 'required|string|min:3',
                'number'        => 'required|numeric',
                'expire_date'   => 'required|string|min:3',
                'cvc'           => 'required|numeric|digits:3',
            ]);
            $payment_status = $this->getPaymentStatus(request('id'), request('resourcePath'));
            return $payment_status;
        }
        return redirect()->route('frontend.home');
    }

    // getPaymentStatus
    private function getPaymentStatus($id, $resourcePath)
    {
        $res  = session()->get(request('session_name'));
        if ($res['payment_brand'] == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($res['payment_brand'] == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url = config('payment_information.hyperpay.get_status_link');
        $url .= $resourcePath;
        $url .= "?entityId=" . $entity_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }
}
