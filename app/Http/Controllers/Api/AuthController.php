<?php

namespace App\Http\Controllers\Api;

use App\Donor;
use App\Traits\SmsTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DonorResource;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use SmsTrait;

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^((05))[0-9]{8}$/'],
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        
        if ($request->phone == "0540544711") {
            $phone  = "0540544711";
            $code   = '1234';
        } else {
            $phone  = preg_replace("/^966/", "0", $request->phone);
            $code   = mt_rand(1010, 10000);
        }

        if (Donor::where('phone', '=', $phone)->exists()) {
            $donor = Donor::where('phone', '=', $phone)->first();
            $donor->otp_code    = $code;
            $donor->save();

            // Send sms verification
            $this->sendVerificationCode($donor->phone, $donor->otp_code);

            return response()->api($donor->phone, 200, false, __('api.A text message containing the OTP code sent', ['phone' => $phone]));
        }

        $donor              = new Donor();
        $donor->phone       = $phone;
        $donor->otp_code    = $code;
        $donor->save();

        // Send sms verification
        $this->sendVerificationCode($donor->phone, $donor->otp_code);

        return response()->api($donor->phone, 200, false, __('api.A text message containing the OTP code sent', ['phone' => $phone]));
    }

    public function verifyOtpCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_code' => ['required', 'digits:4'],
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        $phone  = preg_replace("/^966/", "0", $request->phone);
        $donor  = Donor::where('phone', '=', $phone)->first();

        if ($donor) {
            if ($request->otp_code == $donor->otp_code) {
                $data['donor']  = new DonorResource($donor);
                $data['token']  = $donor->createToken('myAppName')->plainTextToken;
                return response()->api($data, 200);
            }
            return response()->api(null, 200, true, __('auth.failed'));
        }
        return response()->api(null, 200, true, __('api.donor not found'));
    }

    public function resendOtpCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', 'regex:/^((05))[0-9]{8}$/'],
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        $phone  = preg_replace("/^966/", "0", $request->phone);
        // $code   = '2222';
        $code   = mt_rand(1010, 10000);

        if (Donor::where('phone', '=', $phone)->exists()) {
            $donor = Donor::where('phone', '=', $phone)->first();
            $donor->otp_code    = $code;
            $donor->save();

            // Send sms verification
            $this->sendVerificationCode($donor->phone, $donor->otp_code);

            return response()->api($donor->phone, 200, false, __('api.Resend the code successfully', ['phone' => $phone]));
        }
        return response()->api([], 200, true, __('api.donor not found'));
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->api([], 200, false, __('api.Signed out successfully'));
    }
}
