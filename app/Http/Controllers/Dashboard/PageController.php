<?php

namespace App\Http\Controllers\Dashboard;

use App\Page;
use App\Founder;
use App\Director;
use App\Membership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\MessageMembersMail;
use App\Traits\SmsTrait;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    use SmsTrait;
    /*******
     *             -----------
     * ------ ABOUT THE ASSOCIATION ------
     *             -- BRIEF --
     *
    */
    public function viewBrief()
    {
        $brief      = Page::where('key', 'brief')->first();
        $founders   = Founder::query()->paginate(6);
        return view('dashboard.get-to-know-us.brief', compact('brief', 'founders'));
    }

    public function updateBrief(Request $request, $key)
    {
        $brief = Page::where('key', $key)->first();
        if ($brief) {
            $request->validate([
                'value'  => 'nullable|string|min:10',
            ]);
            $data['value'] = $request->value;

            Page::where('key', $key)->first()->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.welcome');
    }

    /*******
     *             -----------
     * ------ ABOUT THE ASSOCIATION ------
     *        -- BOARD-OF-DIRECTORS --
     *
    */
    public function viewDirectors()
    {
        $board_of_directors = Page::where('key', 'board_of_directors')->first();
        $directors   = Director::query()->paginate(6);
        return view('dashboard.get-to-know-us.board-of-directors', compact('board_of_directors', 'directors'));
    }

    public function updateDirectors(Request $request, $key)
    {
        $board_of_directors = Page::where('key', $key)->first();
        if ($board_of_directors) {
            $request->validate([
                'value'  => 'nullable|string|min:10',
            ]);
            $data['value'] = $request->value;

            Page::where('key', $key)->first()->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.welcome');
    }

    /*******
     *             -----------
     * ------ ABOUT THE ASSOCIATION ------
     *        -- SERVICES ALBIR --
     *
    */
    public function viewServicesAlbir()
    {
        $services_albir = Page::where('key', 'services_albir')->first();
        return view('dashboard.get-to-know-us.services-albir', compact('services_albir'));
    }

    public function updateServicesAlbir(Request $request, $key)
    {
        $services_albir = Page::where('key', $key)->first();
        if ($services_albir) {
            $request->validate([
                'value'  => 'nullable|string|min:10',
            ]);
            $data['value'] = $request->value;

            Page::where('key', $key)->first()->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.welcome');
    }

    /*******
     *             -----------
     * ------ ABOUT THE ASSOCIATION ------
     *        -- ORGANIZATIONAL CHART --
     *
    */
    public function viewOrganizationalChart()
    {
        $organizational_chart = Page::where('key', 'organizational_chart')->first();
        return view('dashboard.get-to-know-us.organizational-chart', compact('organizational_chart'));
    }

    public function updateOrganizationalChart(Request $request, $key)
    {
        $organizational_chart = Page::where('key', $key)->first();
        if ($organizational_chart) {
            $request->validate([
                'value'  => 'nullable|string|min:10',
            ]);
            $data['value'] = $request->value;

            Page::where('key', $key)->first()->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.welcome');
    }

    /*******
     *             -----------
     * ------ ABOUT THE ASSOCIATION ------
     *        -- STATISTICS --
     *
    */
    public function viewStatistics()
    {
        $statistics = Page::where('key', 'statistics')->first();
        return view('dashboard.get-to-know-us.statistics', compact('statistics'));
    }

    public function updateStatistics(Request $request, $key)
    {
        $statistics = Page::where('key', $key)->first();
        if ($statistics) {
            $request->validate([
                'value'  => 'nullable|string|min:10',
            ]);
            $data['value'] = $request->value;

            Page::where('key', $key)->first()->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.welcome');
    }

    /*******
     *             -----------
     * ------ ALBIR FRIENDS ------
     *  -- GeneralAssemblyMembers --
     *
    */
    public function viewGeneralAssemblyMembers()
    {
        $general_assembly_members      = Membership::where('key', 'general_assembly_members')->first();
        return view('dashboard.albir-friends.general-assembly-members', compact('general_assembly_members'));
    }

    public function updateGeneralAssemblyMembers(Request $request, $key)
    {
        $general_assembly_members = Membership::where('key', $key)->first();
        if ($general_assembly_members) {
            $request->validate([
                'how_to_join'           => 'sometimes|nullable|string|min:10',
                'joining_terms'         => 'sometimes|nullable|string|min:10',
                'membership_benefits'   => 'sometimes|nullable|string|min:10',
                'img'                   => 'required|mimes:jpg,jpeg,png|max:20000',
            ]);
            $data['how_to_join']            = $request->how_to_join;
            $data['joining_terms']          = $request->joining_terms;
            $data['membership_benefits']    = $request->membership_benefits;

            // image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/pages/' . $general_assembly_members->img);
                $filename       = 'IMG_memberships_' . '_' . time() . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/pages/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            Membership::where('key', $key)->first()->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.welcome');
    }

    /*******
     *             -----------
     * ------ ALBIR FRIENDS ------
     *  -- DonorMembership --
     *
    */
    public function viewDonorMembership()
    {
        $donor_membership      = Membership::where('key', 'donor_membership')->first();
        return view('dashboard.albir-friends.donor-membership', compact('donor_membership'));
    }

    public function updateDonorMembership(Request $request, $key)
    {
        $donor_membership = Membership::where('key', $key)->first();
        if ($donor_membership) {
            $request->validate([
                'how_to_join'           => 'sometimes|nullable|string|min:10',
                'joining_terms'         => 'sometimes|nullable|string|min:10',
                'membership_benefits'   => 'sometimes|nullable|string|min:10',
                'img'                   => 'required|mimes:jpg,jpeg,png|max:20000',
            ]);
            $data['how_to_join']            = $request->how_to_join;
            $data['joining_terms']          = $request->joining_terms;
            $data['membership_benefits']    = $request->membership_benefits;

            // image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/pages/' . $donor_membership->img);
                $filename       = 'IMG_memberships_' . '_' . time() . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/pages/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            Membership::where('key', $key)->first()->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.welcome');
    }

    /*******
     *             -----------
     * ------ ALBIR FRIENDS ------
     *  -- VolunteerMembership --
     *
    */
    public function viewVolunteerMembership()
    {
        $volunteer_membership      = Membership::where('key', 'volunteer_membership')->first();
        return view('dashboard.albir-friends.volunteer-membership', compact('volunteer_membership'));
    }

    public function updateVolunteerMembership(Request $request, $key)
    {
        $volunteer_membership = Membership::where('key', $key)->first();
        if ($volunteer_membership) {
            $request->validate([
                'how_to_join'           => 'sometimes|nullable|string|min:10',
                'joining_terms'         => 'sometimes|nullable|string|min:10',
                'membership_benefits'   => 'sometimes|nullable|string|min:10',
                'img'                   => 'required|mimes:jpg,jpeg,png|max:20000',
            ]);
            $data['how_to_join']            = $request->how_to_join;
            $data['joining_terms']          = $request->joining_terms;
            $data['membership_benefits']    = $request->membership_benefits;

            // image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/pages/' . $volunteer_membership->img);
                $filename       = 'IMG_memberships_' . '_' . time() . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/pages/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            Membership::where('key', $key)->first()->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.welcome');
    }

    /*******
     *             -----------
     * ------ ALBIR FRIENDS ------
     *  -- BeneficiariesMembership --
     *
    */
    public function viewBeneficiariesMembership()
    {
        $beneficiaries_membership      = Membership::where('key', 'beneficiaries_membership')->first();
        return view('dashboard.albir-friends.beneficiaries-membership', compact('beneficiaries_membership'));
    }

    public function updateBeneficiariesMembership(Request $request, $key)
    {
        $beneficiaries_membership = Membership::where('key', $key)->first();
        if ($beneficiaries_membership) {
            $request->validate([
                'how_to_join'           => 'sometimes|nullable|string|min:10',
                'joining_terms'         => 'sometimes|nullable|string|min:10',
                'membership_benefits'   => 'sometimes|nullable|string|min:10',
                'img'                   => 'required|mimes:jpg,jpeg,png|max:20000',
            ]);
            $data['how_to_join']            = $request->how_to_join;
            $data['joining_terms']          = $request->joining_terms;
            $data['membership_benefits']    = $request->membership_benefits;

            // image
            if ($img  = $request->file('img')) {
                Storage::disk('public')->delete('/pages/' . $beneficiaries_membership->img);
                $filename       = 'IMG_memberships_' . '_' . time() . '.' . $img->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/pages/' . $filename);
                Image::make($img->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['img'] = $filename;
            }

            Membership::where('key', $key)->first()->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.welcome');
    }

    /*******
     *         -----------
     * ------ MESSAGE MEMBERS ------
     *            --  --
     *
    */
    public function viewIndividualMessaging()
    {
        return view('dashboard.message-members.individual-messaging');
    }

    public function sendIndividualMessaging(Request $request)
    {
        $data = $request->validate([
            'send_method'   =>  'required|in:email,phone_message',
            'message_title' =>  'required_if:send_method,email|sometimes|nullable|string|min:3',
            'sent_mail'     =>  'required_if:send_method,email|sometimes|nullable|email|max:50',
            'sent_phone'    =>  ['required_if:send_method,phone_message', 'sometimes', 'nullable', 'regex:/^((9665)|(05))[0-9]{8}$/'],
            'message'       =>  'required|string|min:20',
        ]);

        if (setting()->mail_host != null) {
            if ($request->send_method == 'email') {
                Mail::to($data['sent_mail'])->send(new MessageMembersMail($data));
                session()->flash('success', __('dashboard.sended_successfully'));
                return redirect()->back();
            } elseif ($request->send_method == 'phone_message') {
                $this->sendSms($request->sent_phone, strip_tags($request->message));
                session()->flash('success', __('dashboard.sended_successfully'));
                return redirect()->back();
            } else {
                return redirect()->route('dashboard.message-members.individual-messaging.index');
            }
        }
        return 'يرجي ضبط إعدادات الإيميل من صفحة الإعدادات والمحاولة مرة أخري!';
    }
}
