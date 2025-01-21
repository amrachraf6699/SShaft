<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Service;
use App\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\DonorResource;
use App\Http\Resources\DonationResource;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * == Profile
     */
    public function getProfile()
    {
        return response()->api(new DonorResource(auth()->user()), 200);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      =>  'sometimes|nullable|string|min:3|max:30',
            'email'     =>  'sometimes|nullable|email|max:255|unique:donors,email,'. auth()->user()->id,
            'ident_num' =>  'sometimes|nullable|numeric|digits:10|unique:donors,ident_num,'. auth()->user()->id,
            'gender'    =>  'sometimes|nullable|in:male,female',
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'ident_num' => $request->ident_num,
            'gender'    => $request->gender,
        ];
        auth()->user()->update($data);
        return response()->api(new DonorResource(auth()->user()), 200, false, __('api.Updated successfully'));
    }

    public function updateToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'     =>  'required|string',
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        auth()->user()->update(['fcm_token' => $request->token]);
        return response()->api(null, 200, false, __('api.Updated successfully'));
    }

    /**
     * == Cart
     */
    public function getCart()
    {
        $items = auth()->user()->cartsWithServiceValue()->get();
        if ($items->count() > 0) {
            return response()->api(CartResource::collection($items), 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    public function addToCart(Request $request)
    {
        $service    = Service::whereId($request->id)->active()->first();
        if ($service) {
            if (! auth()->user()->carts()->whereServiceId($service->id)->exists()) {
                // validate
                $validator = Validator::make($request->all(), [
                    'quantity'  => 'required|numeric|gt:0',
                    'amount'    => 'required|numeric|gt:0',
                ]);

                if ($validator->fails()) {
                    return response()->api(null, 200, true, $validator->errors()->first());
                }

                // insert data
                $cart               = new Cart();
                $cart->service_id   = $service->id;
                $cart->donor_id     = auth()->user()->id;
                $cart->quantity     = $request->quantity;
                $cart->amount       = $request->amount;
                $cart->save();

                return response()->api(new CartResource($cart), 200, false, __('api.Added Successfully'));
            }

            $cart = auth()->user()->carts()->whereServiceId($service->id)->first();
            $cart = Cart::whereIdAndServiceId($cart->pivot->id, $service->id)->first();
            $cart->increment('quantity');

            return response()->api(new CartResource($cart), 200, false, __('api.Added Successfully'));
        }
        return response()->api(null, 200, true, __('api.not found data'));
    }

    public function changeQuantity(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart) {
            // validate
            $validator = Validator::make($request->all(), [
                'quantity'  => 'required|numeric|gt:0',
            ]);

            if ($validator->fails()) {
                return response()->api(null, 200, true, $validator->errors()->first());
            }

            $cart->update([
                'quantity' => $request->quantity,
            ]);
            return response()->api(new CartResource($cart), 200, false, __('api.Quantity increased', ['quantity', $cart->quantity]));
        }
        return response()->api(null, 200, true, __('api.not found data'));
    }

    public function destroy($id)
    {
        $item = Cart::whereIdAndDonorId($id, auth()->user()->id)->first();
        if ($item) {
            $item->delete();
            return response()->api(null, 200, false, __('api.Successful destroy item from cart', ['item' => $item->service->title]));
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    public function destroyCartAll()
    {
        $items = Cart::select('id')->whereIn('donor_id', [auth()->user()->id])->get();
        if ($items->count() > 0) {
            foreach ($items as $item) {
                $item->delete();
            }
            return response()->api(null, 200, false, __('api.Successful destroy cart all'));
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * == Donations invoices
     */
    public function donationsInvoices()
    {
        $donations = Donation::whereDonorId(auth()->user()->id)->paid()->orderBy('id', 'DESC')->paginate(12);
        if ($donations->count() > 0) {
            $data['donations']   = DonationResource::collection($donations)->response()->getData(true);
            return response()->api($data, 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }
}
