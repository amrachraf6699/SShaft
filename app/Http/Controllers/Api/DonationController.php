<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Donor;
use App\Order;
use App\Service;
use App\Donation;
use App\OrderService;
use App\DonationService;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonationResource;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewDonationForAdminNotify;
use App\Notifications\NewNotifyForDonor;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    use SmsTrait;

    public function isJson($string) {
       json_decode($string);
       return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Order Now
     */
    public function orderNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total_amount'  => 'required|gt:0',
            'quantity'      => 'required|numeric|gt:0',
            'service_id'    => 'required|exists:services,id|integer',
            'phone'         => ['required', 'regex:/^((05))[0-9]{8}$/'],
            'status'        => 'nullable',
            'payment_ways'  => 'required|in:credit_card,bank_transfer',
            'payment_brand' => 'nullable',
            'order_type'    => 'required|in:service,gift,quick',
            'branch_id'     => 'nullable',
            'response'      => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        $succ_msg = 'تم عملية الدفع بنجاح, الرجاء الإنتظار';
        $fail_msg = 'عملية مرفوضة, الرجاء المحاولة مرة اخرى';

        $service    = Service::orderBy('id', 'DESC')->whereId($request->service_id)
                                ->active()->with('service_section')->first();
        if ($service && $service->service_section->status === 'active') {
            $phone  = preg_replace("/^966/", "0", $request->phone);

            if ($this->isJson($request->response)) {
                $json_response = json_decode($request->response);
                $status = $json_response !== null && isset($json_response->responseCode) && $json_response->responseCode == '000' ? 'paid' : 'unpaid';
                $total_amount = $json_response !== null && isset($json_response->amount) ? (float) str_replace(',', '', $json_response->amount) : ((float) str_replace(',', '', $request->total_amount) ?? 0);
            } else {
                $status = 'unpaid';
                $total_amount = is_numeric((float) str_replace(',', '', $request->total_amount)) ? (float) str_replace(',', '', $request->total_amount) : 0;
            }

            $request->merge([
                'status' => $status,
                'total_amount' => $total_amount
            ]);

            if (Donor::where('phone', '=', $phone)->exists()) {
                $donor = Donor::where('phone', '=', $phone)->first();

                try {
                    DB::beginTransaction();
                        $donation                   = new Donation();
                        $donation->donor_id         = $donor->id ?? auth()->user()->id;
                        $donation->total_amount     = intval($request->total_amount);
                        $donation->status           = $request->status ?? 'paid';
                        $donation->payment_ways     = $request->payment_ways == 'bank_transfer' ? 'bank_transfer' : 'credit_card';
                        $donation->payment_brand    = $request->payment_brand ?? 'None';
                        $donation->branch_id        = $request->branch_id;
                        $donation->response         = $request->response;
                        $donation->save();

                        $donation_service               = new DonationService();
                        $donation_service->service_id   = $service->id;
                        $donation_service->donation_id  = $donation->id;
                        $donation_service->quantity     = $request->quantity;
                        $donation_service->amount       = intval($request->total_amount);
                        $donation_service->save();

                        $response = [
                            'order_id'                  => $donation->id,
                            'donor_phone'               => $phone,
                            'donor_id'                  => auth()->user()->id ?? $donor->id,
                            'total_amount'              => $donation->total_amount,
                            'is_paid'                   => $donation->status == 'paid' ? true : false,
                            'message'                   => $donation->status == 'paid' ? $succ_msg : $fail_msg
                        ];

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }

                $message = __('api.Successful operation');

                return response()->api($response, 200, false, $message);
            }

            try {
                DB::beginTransaction();
                    $donor              = new Donor();
                    $donor->phone       = $phone;
                    $donor->save();


                    $donation                   = new Donation();
                    $donation->donor_id         = $donor->id ?? auth()->user()->id;
                    $donation->total_amount     = intval($request->total_amount);
                    $donation->status           = $request->status ?? 'paid';
                    $donation->payment_ways     = $request->payment_ways == 'bank_transfer' ? 'bank_transfer' : 'credit_card';
                    $donation->payment_brand    = $request->payment_brand ?? 'None';
                    $donation->response         = $request->response;
                    $donation->save();

                    $donation_service               = new DonationService();
                    $donation_service->service_id   = $service->id;
                    $donation_service->donation_id  = $donation->id;
                    $donation_service->quantity     = $request->quantity;
                    $donation_service->amount       = intval($request->total_amount);
                    $donation_service->save();


                    $response = [
                        'order_id'                  => $donation->id,
                        'donor_phone'               => $phone,
                        'donor_id'                  => auth()->user()->id ?? $donor->id,
                        'total_amount'              => $donation->total_amount,
                        'is_paid'                   => $donation->status == 'paid' ? true : false,
                        'message'                   => $donation->status == 'paid' ? $succ_msg : $fail_msg
                    ];

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            $message = __('api.Successful operation');

            return response()->api($response, 200, false, $message);
        }
        return response()->api(null, 200, true, __('api.not found data'));
    }


    public function orderSendToDonor(Request $request)
    {
        $setting = setting();
        $validator = Validator::make($request->all(), [
            'order_id'  => 'required',
            'phone'     => 'required',
            'name'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        $phone  = $request->phone;

        if (Donor::where('phone', '=', $phone)->exists()) {
                $donor = Donor::where('phone', '=', $phone)->first();
                $donor->name = $request->name;
                $donor->save();


                $donation = Donation::find($request->order_id);
                $donation->donor_id = $donor->id;
                $donation->save();

                $name = $donor->name;
                $service = DonationService::with('service')->where('donation_id', $donation->id)->latest()->first()->service->title;
                $price = $donation->total_amount;
                $invoice_number = $donation->donation_code;
                $invoice_url = env('APP_URL') . "donation-invoice/$invoice_number/show";

                $message = "أ/ $name \n";
                $message .= "شكرًا لك لتبرعك بمبلغ $price ريال سعودي \n";
                $message .= "لغرض: $service \n";
                $message .= "رقم السند: $invoice_number \n";
                $message .= "لمشاهدة السند: $invoice_url \n\n";
                $message .= $setting->name ;//"برُّكُم - جمعية البر بمكة المكرمة";

                $this->sendSms($phone, $message);

                $response = [
                    "donor" => $donor,
                    "donation" => $donation
                ];

                return response()->api($response, 200, false, __('api.Successful operation'));
        }

        try {
            DB::beginTransaction();
                $donor              = new Donor();
                $donor->phone       = $phone;
                $donor->name        = $request->name;
                $donor->save();

                $donation = Donation::find($request->order_id);
                $donation->donor_id = $donor->id;
                $donation->save();

                $name = $donor->name;
                $service = DonationService::with('service')->where('donation_id', $donation->id)->latest()->first()->service->title;
                $price = $donation->total_amount;
                $invoice_number = $donation->donation_code;
                $invoice_url = env('APP_URL') . "donation-invoice/$invoice_number/show";

                $message = "أ/ $name \n";
                $message .= "شكرًا لك لتبرعك بمبلغ $price ريال سعودي \n";
                $message .= "لغرض: $service \n";
                $message .= "رقم السند: $invoice_number \n";
                $message .= "لمشاهدة السند: $invoice_url \n\n";
                $message .= $setting->name ;//"برُّكُم - جمعية البر بمكة المكرمة";

                $this->sendSms($phone, $message);

                $response = [
                    "donor" => $donor,
                    "donation" => $donation
                ];

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->api($response, 200, false, __('api.Successful operation'));
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus($checkout_id, $payment_brand, $order_id)
    {
        if ($payment_brand == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($payment_brand == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url =  config('payment_information.hyperpay.get_status_link') . "/v1/checkouts/" . $checkout_id;
	    $url .= "/payment?entityId=" . $entity_id;

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

        $res            = json_decode($responseData, true);
        $result_code    = $res['result']['code'];
        $item           = Order::whereId($order_id)->first();
        // Storage::disk('public')->put('res_pay.json', json_encode($res));
        if ($item) {
            if (($result_code == '000.100.110' || $result_code == '000.000.000' || $result_code == '000.300.000') && isset($res['merchantTransactionId']) && !empty($res['merchantTransactionId'])) { // success payment id >> transaction bank id
                return response()->api([
                    'payment_status'    =>  true,
                    'result_code'       =>  $result_code,
                    'message'           =>  __('api.The payment completed successfully.'),
                ], 200, false, __('api.Successful operation'));
            } else {
                $item->delete();
                return response()->api([
                    'payment_status'    =>  false,
                    'result_code'       =>  $result_code,
                    'message'           =>  __('api.The payment was not successful.'),
                ], 200, false, __('api.Successful operation'));
            }
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }



    /**
     * Donation completed
     */
    public function donationCompleted($order_id)
    {
        $order   = Order::whereId($order_id)->first();
        if ($order) {
            try {
                DB::beginTransaction();
                    $data = [
                        'donor_id'              => auth()->user()->id ?? $order->donor_id,
                        'total_amount'          => $order->total_amount,
                        'bank_transaction_id'   => $order->merchant_transaction_id,
                        'payment_brand'         => $order->payment_brand,
                        'status'                => 'paid',
                        'payment_ways'          => 'credit_card',
                    ];

                    $donation = Donation::create($data);

                    foreach ($order->details as $i_order) {
                        $donation_service               = new DonationService();
                        $donation_service->service_id   = $i_order->service_id;
                        $donation_service->donation_id  = $donation->id;
                        $donation_service->quantity     = $i_order->quantity;
                        $donation_service->amount       = $donation->total_amount;
                        $donation_service->save();
                    }

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
                    $this->sendSms($donation->donor->phone, __('messages.donation_completion_msg', ['invoice_link' => $route, 'review_link' => $review_link]));

                    $donation->donor->notify(new NewNotifyForDonor($donation));
                    User::each(function($admin, $key) use ($donation) {
                        $admin->notify(new NewDonationForAdminNotify($donation));
                    });

                    $order->delete();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            return response()->api(new DonationResource($donation), 200, false, __('api.Successful operation'));
        }
        return response()->api(null, 200, true, __('api.not found data'));
    }
}
