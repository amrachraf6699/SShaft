<?php

namespace App\Http\Controllers\Frontend;

use App\Cart;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $pageTitle      = __('translation.cart');
        $items          = auth('donor')->user()->cartsWithServiceValue()->get();
        $totalDonations = auth('donor')->user()->donations()->paid()->withCount('services')->get();
        return view('frontend.profile.cart', compact('pageTitle', 'items', 'totalDonations'));
    }

    public function store(Request $request, $service)
    {
        if(Auth::guard('donor')->check() && Auth::guard('donor'))
        {
            $service    = Service::whereId($service)->active()->first();
            if($service) {
                if (! auth('donor')->user()->carts()->whereServiceId($service->id)->exists()) {
                    // validate
                    $request->validate(['quantity'  => 'required|numeric', 'amount' => 'required|numeric',]);
                    // insert data
                    $cart               = new Cart();
                    $cart->service_id   = $service->id;
                    $cart->donor_id     = auth('donor')->user()->id;
                    $cart->quantity     = $request->quantity;
                    $cart->amount       = $request->amount;
                    $cart->save();
                    session()->flash('sessionCartSuccess');
                    return redirect()->back();
                }
                session()->flash('sessionCartSuccess');
                return redirect()->back();
            }
            return redirect()->route('frontend.home');
        } else {
            session()->flash('sessionAuthError');
            return redirect()->back();
        }
    }

    public function destroy($itemId)
    {
        $item = Cart::whereServiceIdAndDonorId($itemId, auth('donor')->user()->id)->first();
        if ($item) {
            $item->delete();
            session()->flash('sessionSuccess', 'تم حذف الخدمة من سلة التبرعات بنجاح!');
            return redirect()->back();
        }
        return redirect()->route('frontend.home');
    }

    public function emptyTheCart()
    {
        $items = Cart::select('id')->whereIn('donor_id', [auth('donor')->user()->id]);
        if ($items) {
            $items->delete();
            session()->flash('sessionSuccess', 'تم تفريغ سلة التبرعات بنجاح!');
            return redirect()->back();
        }
    }
}
