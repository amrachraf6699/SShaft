<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Donor;
use App\Service;
use App\Donation;
use App\Marketer;
use App\DonationService;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\NewDonationForAdminNotify;

class MarketerController extends Controller
{
    use SmsTrait;

    public function index($username)
    {
        $marketer   = Marketer::whereUsername($username)->active()->first();

        if ($marketer) {
            $pageTitle  = __('translation.donate_online');
            $section    = $marketer->marketerPermissions()->pluck('id')->toArray();

            if (empty($section)) {
                $services   = Service::query()
                                    ->with('service_section:id,slug,title')
                                    ->whereHas('service_section', function($q) {
                                        $q->whereStatus('active');
                                    })
                                    ->orderBy('id', 'DESC')
                                    ->active()->paginate(6);
            } else {
                $services   = Service::query()
                                    ->with('service_section:id,slug,title')
                                    ->whereHas('service_section', function($q) {
                                        $q->whereStatus('active');
                                    })
                                    ->whereIn('service_section_id', $section)
                                    ->orderBy('id', 'DESC')
                                    ->active()->paginate(6);
            }

            // PAYMENT PROVIDER
            if(request('id') && request('resourcePath')) {
                $res            = session()->get(request('session_name'));
                $phone          = $res['phoneNumber'];
                $serviceId      = $res['serviceId'];
                $payment_status = $this->getPaymentStatus(request('id'), request('resourcePath'));
                $result_code    = $payment_status['result']['code'];

                if (($result_code == '000.100.110' || $result_code == '000.000.000' || $result_code == '000.300.000') && isset($payment_status['merchantTransactionId']) && !empty($payment_status['merchantTransactionId'])) { // success payment id >> transaction bank id
                    $showSuccessPaymentMessage = true;
                    // save transaction in donation table with transaction id  = $payment_status['id]
                    if (Donor::where('phone', '=', $phone)->exists()) {
                        $donor = Donor::where('phone', '=', $phone)->first();

                        $data = [
                            'donor_id'              => auth('donor')->user()->id ?? $donor->id,
                            'total_amount'          => $payment_status['amount'],
                            'bank_transaction_id'   => $payment_status['merchantTransactionId'],
                            'payment_brand'         => $payment_status['paymentBrand'],
                            'status'                => 'paid',
                            'payment_ways'          => 'credit_card',
                            'donation_type'         => 'marketer',
                            'marketer_id'           => $marketer->id,
                        ];

                        $donation = Donation::create($data);

                        $donation_service               = new DonationService();
                        $donation_service->service_id   = $serviceId;
                        $donation_service->donation_id  = $donation->id;
                        $donation_service->quantity     = $res['quantity'];
                        $donation_service->amount       = $donation->total_amount;
                        $donation_service->save();

                        // update "collected_value" in service
                        $services = $donation->services()->get();
                        foreach ($services as $service) {
                            $service->update([
                                'collected_value'  => $service->collected_value + $service->pivot->amount,
                            ]);
                        }

                        // Send sms
                        $route = route('donation-invoice.show', $donation->donation_code);
                        $review_link = route('frontend.reviews.index', $donation->donation_code);
                        $this->sendSms($donor->phone, __('messages.donation_completion_msg', ['invoice_link' => $route, 'review_link' => $review_link]));

                        User::each(function($admin, $key) use ($donation) {
                            $admin->notify(new NewDonationForAdminNotify($donation));
                        });

                        session()->flash('sessionSuccess', 'تمت العملية بنجاح، جعله الله عملاً خالصاً في ميزان حسناتكم!');
                        return redirect()->route('frontend.reviews.index', $donation->donation_code);
                    }

                    $donor              = new Donor();
                    $donor->phone       = $phone;
                    $donor->save();

                    $data = [
                        'donor_id'              => $donor->id,
                        'total_amount'          => $payment_status['amount'],
                        'bank_transaction_id'   => $payment_status['merchantTransactionId'],
                        'payment_brand'         => $payment_status['paymentBrand'],
                        'status'                => 'paid',
                        'payment_ways'          => 'credit_card',
                        'donation_type'         => 'marketer',
                        'marketer_id'           => $marketer->id,
                    ];

                    $donation = Donation::create($data);

                    $donation_service               = new DonationService();
                    $donation_service->service_id   = $serviceId;
                    $donation_service->donation_id  = $donation->id;
                    $donation_service->quantity     = $res['quantity'];
                    $donation_service->amount       = $donation->total_amount;
                    $donation_service->save();

                    // update "collected_value" in service
                    $services = $donation->services()->get();
                    foreach ($services as $service) {
                        $service->update([
                            'collected_value'  => $service->collected_value + $service->pivot->amount,
                        ]);
                    }

                    // Send sms
                    $route = route('donation-invoice.show', $donation->donation_code);
                    $review_link = route('frontend.reviews.index', $donation->donation_code);
                    $this->sendSms($donor->phone, __('messages.donation_completion_msg', ['invoice_link' => $route, 'review_link' => $review_link]));

                    User::each(function($admin, $key) use ($donation) {
                        $admin->notify(new NewDonationForAdminNotify($donation));
                    });

                    session()->flash('sessionSuccess', 'تمت العملية بنجاح، جعله الله عملاً خالصاً في ميزان حسناتكم!');
                    return redirect()->route('frontend.reviews.index', $donation->donation_code);

                } else {
                    $showFailPaymentMessage = true;
                    session()->flash('sessionError', 'فشلت عملية الدفع، الرجاء التحقق وإعادة المحاولة!');
                    return redirect()->route('frontend.services-sections', $section->slug);
                }
            }

            return view('frontend.services.marketer-services', compact('services', 'pageTitle', 'marketer'));
        }
        return abort(404);
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
