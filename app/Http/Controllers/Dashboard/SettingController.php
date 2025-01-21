<?php

namespace App\Http\Controllers\Dashboard;

use App\Setting;
use App\ServiceSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SettingRequest;

class SettingController extends Controller
{
    public function index()
    {
        $sections = ServiceSection::orderBy('id', 'DESC')->active()->pluck('title', 'id');
        return view('dashboard.settings.index', compact('sections'));
    }

    public function update(SettingRequest $request)
    {
        $setting = Setting::orderBy('id', 'DESC')->first();
        if ($setting) {
            $data = $request->validated();
            
            if ($logo_img  = $request->file('logo')) {
                Storage::disk('public')->delete('/settings/' . $setting->logo);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $logo_img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/settings/' . $filename);
                Image::make($logo_img->getRealPath())->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['logo'] = $filename;
            }
            
            if ($fav_img  = $request->file('fav')) {
                Storage::disk('public')->delete('/settings/' . $setting->fav);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $fav_img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/settings/' . $filename);
                Image::make($fav_img->getRealPath())->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['fav'] = $filename;
            }
            
            Setting::orderBy('id', 'desc')->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function mailUpdate(Request $request)
    {
        $setting = Setting::orderBy('id', 'DESC')->first();
        if ($setting) {
            $data = $request->validate([
                'mail_mailer'       => 'required',
                'mail_encryption'   => 'required',
                'mail_host'         => 'required',
                'mail_port'         => 'required',
                'mail_username'     => 'required',
                'mail_password'     => 'required',
                'mail_from_address' => 'required|email|max:255',
                'mail_from_name'    => 'required|string',
            ]);

            Setting::orderBy('id', 'desc')->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function templateMailUpdate(Request $request)
    {
        $setting = Setting::orderBy('id', 'DESC')->first();
        if ($setting) {
            $data = $request->validate([
                'header_temp'   => 'required|string',
                'footer_temp'   => 'required|string',
            ]);

            Setting::update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function status(Request $request)
    {
        $setting = Setting::orderBy('id', 'DESC')->first();
        if ($setting) {
            $data = $request->validate([
                'status'                => 'required|in:open,close',
                'message_maintenance'   => 'required_if:status,close|sometimes|nullable',
            ]);

            Setting::orderBy('id', 'desc')->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function socialMediaUpdate(Request $request)
    {
        $social_media = Setting::orderBy('id', 'DESC')->first();
        if ($social_media) {
            $data = $request->validate([
                'facebook'     =>  'sometimes|nullable|url',
                'twitter'      =>  'sometimes|nullable|url',
                'instagram'    =>  'sometimes|nullable|url',
                'snapchat'     =>  'sometimes|nullable|url',
                'youtube'      =>  'sometimes|nullable|url',
                'whatsapp'     =>  'sometimes|nullable',
            ], [], [
                'facebook'     =>  trans('dashboard.facebook'),
                'twitter'      =>  trans('dashboard.twitter'),
                'instagram'    =>  trans('dashboard.instagram'),
                'snapchat'     =>  trans('dashboard.snapchat'),
                'youtube'      =>  trans('dashboard.youtube'),
                'whatsapp'     =>  trans('dashboard.whatsapp'),
            ]);

            Setting::orderBy('id', 'desc')->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->back();
    }
    
    public function sectionIdOnTheHomePage(Request $request)
    {
        $setting = Setting::orderBy('id', 'DESC')->first();
        if ($setting) {
            $data = $request->validate([
                'section_id_on_the_home_page'   => 'sometimes|nullable|exists:service_sections,id|integer',
            ]);

            Setting::orderBy('id', 'desc')->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->back();
    }
    
    public function smsSetting(Request $request)
    {
        $setting = Setting::orderBy('id', 'DESC')->first();
        if ($setting) {
            $data = $request->validate([
                'sms_token'   => 'sometimes|nullable|string|max:255',
                'sms_sender'  => 'sometimes|nullable|string|max:255',
            ]);

            Setting::orderBy('id', 'desc')->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->back();
    }
    
    public function updateAdvancedSettings(Request $request)
    {
        $setting = Setting::orderBy('id', 'DESC')->first();
        if ($setting) {
            // Ensure boolean values are handled explicitly
            $data = $request->all();
            $data['is_refresh'] = $request->boolean('is_refresh', false) ? 1 : 0;
            $data['pinned_mode'] = $request->boolean('pinned_mode', false) ? 1 : 0;
            $data['nearpay']['enableReceiptUi'] = $request->boolean('nearpay.enableReceiptUi', false) ? 1 : 0;
    // dd($data);
            // Validate the rest of the request data
            $validated = $request->validate([
                'refresh_time' => 'required|integer|min:0',
                'nearpay.finishTimeout' => 'required|integer|min:0',
                'nearpay.authType' => 'required|string',
                'nearpay.authValue' => 'required|string',
                'nearpay.env' => 'required|string',
            ]);
    
            // Format and merge nearpay data
            $validated['nearpay'] = json_encode([
                'enableReceiptUi' => $data['nearpay']['enableReceiptUi'],
                'finishTimeout' => $validated['nearpay']['finishTimeout'],
                'authType' => $validated['nearpay']['authType'],
                'authValue' => $validated['nearpay']['authValue'],
                'env' => $validated['nearpay']['env'],
            ]);
    
            // Include boolean values explicitly
            $validated['is_refresh'] = $data['is_refresh'];
            $validated['pinned_mode'] = $data['pinned_mode'];
    
            // Update the settings
            $setting->update($validated);
    
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
    
        return redirect()->back()->withErrors(__('dashboard.error_updating'));
    }




}
