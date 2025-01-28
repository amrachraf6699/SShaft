<?php

namespace App\Http\Controllers\Api;

use App\Page;
use App\User;
use App\Event;
use App\Branch;
use App\Slider;
use App\Contact;
use App\Founder;
use App\Setting;
use App\Service;
use App\Beneficiary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Resources\BranchResource;
use App\Http\Resources\FounderResource;
use App\Http\Resources\SettingResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BeneficiaryResource;
use App\Notifications\NewContactForAdminNotify;
use App\Http\Resources\ContactInformationResource;

class HomeController extends Controller
{
    /**
     * Search of services
     */
    public function search(Request $request)
    {
        $keyword    = (isset(request()->keyword) && request()->keyword != '') ? request()->keyword : null;
        $services   = Service::query()->active();

        if ($keyword != null) {
            $services = $services->search($keyword);
        }

        $services   = $services->limit(6)->get();

        if ($services->count() > 0) {
            return response()->api(ServiceResource::collection($services), 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Donate online
     */
    public function donateOnline()
    {
        $services = Service::query()->wherePriceValue('fixed')->active()->inRandomOrder()->limit(4)->get();
        if ($services->count() > 0) {
            return response()->api(ServiceResource::collection($services), 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Beneficiaries
     */
    public function beneficiaries()
    {
        $beneficiaries   = Beneficiary::query()->with('service_section')->orderBy('id', 'DESC')->active()->inRandomOrder()->limit(4)->get();
        if ($beneficiaries->count() > 0) {
            return response()->api(BeneficiaryResource::collection($beneficiaries), 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Association projects
     */
    public function associationProjects()
    {
        $services = Service::query()->quick_donation()->active()->inRandomOrder()->limit(2)->get();
        if ($services->count() > 0) {
            return response()->api(ServiceResource::collection($services), 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Events
     */
    public function events()
    {
        $events = Event::query()->active()->orderBy('id', 'DESC')->limit(2)->get();
        if ($events->count() > 0) {
            return response()->api(EventResource::collection($events), 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Get to know us
     */
    public function brief()
    {
        $brief      = Page::where('key', 'brief')->first();
        $founders   = Founder::query()->get();
        if ($brief->value || $founders->count() > 0) {
            return response()->api([
                'brief'     => $brief->value ? $brief->value : null,
                'founders'  => FounderResource::collection($founders),
            ], 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * branches
     */
    public function branches()
    {
        $branches   = Branch::query()->active()->get();
        if ($branches->count() > 0) {
            return response()->api(BranchResource::collection($branches), 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * sliders
     */
    public function sliders($type = "home")
    {
        $setting = Setting::first();
        if (!in_array($type, ['home', 'section'])) {
            abort(404);
        }

        $branchId = request()->branch_id;

        $query = Slider::query()
            ->active()
            ->where('type', $type);

            if($setting->branch_in_slider)
            {
                $query = $query->whereRaw("FIND_IN_SET(?, REPLACE(branch_id, ' ', ''))", [(int)$branchId]);
            }
            $sliders = $query->inRandomOrder()
            ->limit(4)
            ->get();

        if ($sliders->isNotEmpty()) {
            return response()->api(SliderResource::collection($sliders), 200);
        }

        return response()->api(null, 200, false, __('api.not found data'));
    }


    /**
     * Contact us
     */
    public function contactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      =>  'required|string|min:3|max:50',
            'email'     =>  'required|email|max:255',
            'phone'     =>  'required|numeric',
            'subject'   =>  'required|string|max:255',
            'message'   =>  'required|string|min:20',
        ]);

        if ($validator->fails()) {
            return response()->api(null, 200, true, $validator->errors()->first());
        }

        $contact = Contact::create([
            'name'      =>  $request->name,
            'email'     =>  $request->email,
            'phone'     =>  $request->phone,
            'subject'   =>  $request->subject,
            'message'   =>  $request->message,
        ]);

        User::each(function($admin, $key) use ($contact) {
            $admin->notify(new NewContactForAdminNotify($contact));
        });

        return response()->api(null, 200, false, __('api.Your message was sent successfully'));
    }

    /**
     * Contact Information
     */
    public function contactInformation()
    {
        $settings = Setting::query()->get();
        if ($settings->count() > 0) {
            return response()->api(ContactInformationResource::collection($settings), 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }

    /**
     * Setting Information
     */
    public function settings()
    {
        $branch = request()->branch_id ? Branch::where('id', request()->branch_id)->first() : null;
        $settings = Setting::query()->get();
        if($branch)
        {
            $branch->update(['last_online_at' => now()]);
        }else{
            $settings->first()->update(['last_online_at' => now()]);
        }
        if ($settings->count() > 0) {
            return response()->api(SettingResource::collection($settings), 200);
        }
        return response()->api(null, 200, false, __('api.not found data'));
    }
}
