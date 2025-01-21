<?php

namespace App\Http\Controllers\Frontend;

use App\Donor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ValidateDonorNumber;
use App\Traits\SmsTrait;

class DonorController extends Controller
{
    use SmsTrait;
    /**
     * **** **** **** **** *
     * **** ADD A GIFT ****
     * *** ***** **** **** *
    */
    public function sendOtp(ValidateDonorNumber $request)
    {
        $phone  = preg_replace("/^966/", "0", $request->phone);
        $code   = mt_rand(1010, 10000);

        if (Donor::where('phone', '=', $phone)->exists()) {
            $donor = Donor::where('phone', '=', $phone)->first();
            $donor->otp_code    = $code;
            $donor->save();

            // Send sms verification
            $this->sendVerificationCode($donor->phone, $donor->otp_code);

            return redirect()->route('frontend.verifyOtpView', $donor->phone);
        }

        $donor              = new Donor();
        $donor->phone       = $phone;
        $donor->otp_code    = $code;
        $donor->save();

        // Send sms verification
        $this->sendVerificationCode($donor->phone, $donor->otp_code);

        return redirect()->route('frontend.verifyOtpView', $donor->phone);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required',
        ]);

        $phone  = preg_replace("/^966/", "0", $request->phone);
        $donor  = Donor::where('phone', '=', $phone)->first();

        if($request->otp_code == $donor->otp_code){
            auth('donor')->login($donor);
            return redirect()->route('frontend.add-a-gift');
        } else {
            return redirect()->back()->with('error', 'الكود الخاص بك غير صحيح، يرجي التأكد وإعادة المحاولة');
        }

    }

    public function verifyOtpView($phone)
    {
        $donor = Donor::where('phone', '=', $phone)->first();
        if ($donor)
        {
            $pageTitle  = __('translation.check_phone');
            return view('frontend.pages.send-otp', compact('pageTitle', 'donor'));
        }
        return redirect()->route('frontend.home');
    }

    /**
     * **** **** **** **** *
     * **** QUICK DONATION ****
     * *** ***** **** **** *
    */
    public function sendOtpDonation(ValidateDonorNumber $request)
    {
        $phone  = preg_replace("/^966/", "0", $request->phone);
        $code   = mt_rand(1010, 10000);

        if (Donor::where('phone', '=', $phone)->exists()) {
            $donor = Donor::where('phone', '=', $phone)->first();
            $donor->otp_code    = $code;
            $donor->save();

            // Send sms verification
            $this->sendVerificationCode($donor->phone, $donor->otp_code);

            return redirect()->route('frontend.quick-donation.verifyOtpView', $donor->phone);
        }

        $donor              = new Donor();
        $donor->phone       = $phone;
        $donor->otp_code    = $code;
        $donor->save();

        // Send sms verification
        $this->sendVerificationCode($donor->phone, $donor->otp_code);

        return redirect()->route('frontend.quick-donation.verifyOtpView', $donor->phone);
    }

    public function verifyOtpDonation(Request $request)
    {
        $request->validate([
            'otp_code' => 'required',
        ]);

        $phone  = preg_replace("/^966/", "0", $request->phone);
        $donor  = Donor::where('phone', '=', $phone)->first();

        if($request->otp_code == $donor->otp_code){
            auth('donor')->login($donor);
            return redirect()->route('frontend.profile.show-profile-information', auth('donor')->user()->username);
        } else {
            return redirect()->back()->with('error', 'الكود الخاص بك غير صحيح، يرجي التأكد وإعادة المحاولة');
        }

    }

    public function verifyOtpViewDonation($phone)
    {
        $donor = Donor::where('phone', '=', $phone)->first();
        if ($donor)
        {
            $pageTitle  = __('translation.check_phone');
            return view('frontend.pages.send-otp-quick-donation', compact('pageTitle', 'donor'));
        }
        return redirect()->route('frontend.home');
    }
}
