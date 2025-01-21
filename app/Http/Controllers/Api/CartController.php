<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\User;
use App\Order;
use App\Donation;
use App\OrderService;
use App\DonationService;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonationResource;
use App\Notifications\NewNotifyForDonor;
use Illuminate\Support\Facades\Validator;
use App\Notifications\NewDonationForAdminNotify;

class CartController extends Controller
{
    use SmsTrait;

    /**
     *
     * Cart => Donations Pay Now
     */
    public function orderNow(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_ways'  => 'required|in:credit_card,bank_transfer',
            'payment_brand' => 'required_if:payment_ways,credit_card|in:VISA MASTER,APPLEPAY,MADA',
            'total_amount'  => 'required',
            'service_id'    => 'required'
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        // $cartTotal = Cart::whereDonorId(auth()->user()->id)->select(
        //                     DB::raw('quantity * amount as total_amount')
        //                 )->get()->sum('total_amount');
        // $items = auth()->user()->cartsWithServiceValue()->get();

        // if ($items->count() > 0) {
            try {
                DB::beginTransaction();
                    $data = [
                        'donor_id'              => auth()->user()->id,
                        'total_amount'          => $request->total_amount,
                        'payment_ways'          => $request->payment_ways,
                        'payment_brand'         => $request->payment_brand,
                        'order_type'            => 'service',
                    ];

                    $order = Order::create($data);

                    // foreach($items as $item) {
                        $order_service               = new OrderService();
                        $order_service->service_id   = $request->service_id;
                        $order_service->order_id     = $order->id;
                        $order_service->quantity     = 1; // $request->quantity;
                        $order_service->amount       = $request->total_amount;
                        $order_service->save();
                    // }

                    $response = [
                        'order_id'                  => $order->id,
                        'donor_phone'               => auth()->user()->phone,
                        'donor_id'                  => auth()->user()->id,
                        'total_amount'              => $order->total_amount,
                        'merchant_transaction_id'   => $order->merchant_transaction_id,
                        'payment_ways'              => $order->payment_ways,
                        'payment_brand'             => $order->payment_brand,
                        'order_type'                => 'service',
                    ];
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            return response()->api($response, 200, false, __('api.Successful operation'));
        // }
        // return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Cart completed
     */
    public function cartCompleted($order_id)
    {
        $order   = Order::whereId($order_id)->first();
        if ($order) {
            try {
                DB::beginTransaction();
                    $data = [
                        'donor_id'              => auth('donor')->user()->id ?? $order->donor_id,
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
                        $donation_service->amount       = $i_order->amount;
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
                    $this->sendSms($donation->donor->phone, __('messages.donation_completion_msg', ['invoice_link' => $route]));

                    User::each(function($admin, $key) use ($donation) {
                        $admin->notify(new NewDonationForAdminNotify($donation));
                    });

                    $order->delete();
                    auth()->user()->cartsWithServiceValue()->delete();
                    $donation->donor->notify(new NewNotifyForDonor($donation));
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
