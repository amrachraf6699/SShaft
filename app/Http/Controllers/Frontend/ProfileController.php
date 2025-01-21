<?php

namespace App\Http\Controllers\Frontend;

use App\Donation;
use App\Donor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:donor');
    }

    public function showProfileInformation($username)
    {
        $profile = Donor::whereUsername($username)->first();
        if($profile && $profile->username == auth('donor')->user()->username)
        {
            $pageTitle      = __('web.profile');
            $totalDonations = auth('donor')->user()->donations()->paid()->withCount('services')->get();
            return view('frontend.profile.profile-information', compact('pageTitle', 'profile', 'totalDonations'));
        }
        return redirect()->route('frontend.home');
    }

    public function updateProfileInformation(Request $request, $id)
    {
        $data = $request->validate([
            'name'          => 'sometimes|nullable|string|min:3',
            'email'         => 'sometimes|nullable|email|max:255|unique:donors,email,'. $id,
            // 'phone'         => 'required|numeric|unique:donors,phone,'. $id,
            // 'password'      => 'sometimes|nullable|same:password_confirmation|min:8',
        ]);

        $profile = Donor::whereId($id)->first();

        if($profile && $profile->id == auth('donor')->user()->id)
        {
            // $data = $request->except(['password', 'password_confirmation']);
            // if (trim($request->password) != '') {
            //     $data['password'] = bcrypt($request->password);
            // }
            $profile->update($data);
            session()->flash('sessionSuccess', 'تم تحديث بياناتكم بنجاح!');
            return redirect()->back();
        }
        return redirect()->route('frontend.home');
    }

    public function myBills()
    {
        $donor = auth('donor')->user();
        if ($donor) {
            $bills   = Donation::whereDonorId($donor->id)
                                ->withCount('services')
                                ->orderBy('id', 'DESC')->paginate(6);
            $pageTitle      = __('translation.my_bills');
            $totalDonations = auth('donor')->user()->donations()->paid()->withCount('services')->get();
            return view('frontend.profile.bills', compact('pageTitle', 'bills', 'totalDonations'));
        }
        return redirect()->route('frontend.home');
    }
}
