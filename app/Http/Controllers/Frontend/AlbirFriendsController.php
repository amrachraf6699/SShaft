<?php

namespace App\Http\Controllers\Frontend;

use App\Donor;
use App\Package;
use App\Membership;
use App\Beneficiary;
use App\Neighborhood;
use Illuminate\Http\Request;
use App\GeneralAssemblyMember;
use App\GeneralAssemblyInvoice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use App\Mail\GeneralAssemblyMemberMail;
use App\Events\GeneralAssemblyMemberCreated;
use App\Http\Requests\Frontend\GeneralAssemblyMemberRequest;
use App\Traits\SendSmsToTheGeneralAssemblyMember;

class AlbirFriendsController extends Controller
{
    use SendSmsToTheGeneralAssemblyMember;
    /*******
     *
     * ------ VIEW ALBIR FRIENDS ------
     *
    */
    public function viewAlbirFriends()
    {
        $pageTitle                  = __('translation.albir_friends');
        $packages                   = Package::query()->get();
        $general_assembly_members   = Membership::where('key', 'general_assembly_members')->first();
        $donor_membership           = Membership::where('key', 'donor_membership')->first();
        $volunteer_membership       = Membership::where('key', 'volunteer_membership')->first();
        $beneficiaries_membership   = Membership::where('key', 'beneficiaries_membership')->first();
        return view('frontend.pages.albir-friends', compact(
                        'packages', 'general_assembly_members',
                        'donor_membership', 'volunteer_membership',
                        'beneficiaries_membership', 'pageTitle'
                    ));
    }

    /**
     *
     * ------- View the list of members of the General Assembly ----
     */
    public function viewTheListOfMembersOfTheGeneralAssembly()
    {
        $pageTitle  = __('translation.albir_friends') . ' » ' . __('translation.general_assembly_members');
        $members    = GeneralAssemblyMember::query()->active()->with('package:id,title')->paginate(9);

        return view('frontend.pages.list-of-members-of-the-general-assembly', compact('pageTitle', 'members'));
    }

    /*******
     *
     * ------ GENERAL ASSEMBLY MEMBERS ------
     *
    */
    public function formGeneralAssemblyMembers($slug)
    {
        $package = Package::whereSlug($slug)->first();
        if($package) {
            $pageTitle  = __('translation.albir_friends');
            return view('frontend.pages.albir-friends-join-form', compact('pageTitle', 'package'));
        }
        return redirect()->route('frontend.home');
    }

    public function storeGeneralAssemblyMembers(GeneralAssemblyMemberRequest $request, $slug)
    {
        $package = Package::whereSlug($slug)->first();
        if($package) {
            $data = $request->validated();

            try {
                DB::beginTransaction();
                    // attachments
                    $attachments    = $request->file('attachments');
                    $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $attachments->getClientOriginalExtension();
                    $path           = storage_path('app/public/uploads/general_assembly_members/' . $filename);
                    Image::make($attachments->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path, 100);
                    $data['attachments']        = $filename;
                    $data['subscription_date']  = date('Y-m-d');

                    $member = GeneralAssemblyMember::create($data);

                    $invoice = new GeneralAssemblyInvoice();
                    $invoice->general_assembly_member_id    = $member->id;
                    $invoice->total_amount                  = $member->package->price;
                    $invoice->payment_ways                  = $member->payment_ways;
                    $invoice->subscription_date             = $member->subscription_date;
                    $invoice->expiry_date                   = $member->expiry_date;
                    $invoice->save();

                    $member = [
                        'name'              => $member->full_name,
                        'status'            => 'pending',
                        'email'             => $member->email,
                        'phone'             => $member->phone,
                        'invoice_no'        => $invoice->invoice_no,
                        'subscription_date' => $invoice->subscription_date,
                        'expiry_date'       => $invoice->expiry_date,
                        'total_amount'      => $invoice->total_amount,
                        'payment_ways'      => $invoice->payment_ways,
                    ];

                    // send SMS to member
                    $this->register($member['phone'], $member);
                    // send email to member
                    // event(new GeneralAssemblyMemberCreated($member));
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            session()->flash('sessionSuccess', 'تمت العملية بنجاح، سيتم المراجعة والتأكد من بياناتكم والتواصل معكم لإتمام عملية التسجيل، نشكر لكم ثقتكم بنا!');
            return redirect()->back();
        }
        return redirect()->route('frontend.home');
    }

    /*******
     *
     * ------ VIEW REGISTRATION FORM ------
     *
    */
    public function viewRegistrationForm($slug)
    {
        if ($slug === 'beneficiaries_membership' || $slug === 'donor_membership') {
            $pageTitle          =   __('translation.albir_friends')  . ' » ' . 'تسجيل عضوية';
            $verification_code  =   mt_rand(1010, 10000);
            $neighborhoods      =   Neighborhood::orderBy('id', 'DESC')->active()->pluck('name', 'id');
            return view('frontend.pages.registration-form', compact('slug', 'pageTitle', 'verification_code', 'neighborhoods'));
        }
        return redirect()->route('frontend.home');
    }

    public function storeRegistrationForm(Request $request, $slug)
    {
        if ($slug == 'beneficiaries_membership')
        {
            $data = $request->validate([
                'phone'             =>  'required|numeric|regex:/^(9665)([0-9]{8})$/|unique:beneficiaries,phone',
                'name'              =>  'required|string|min:3',
                'email'             =>  'sometimes|nullable|email|max:255|unique:beneficiaries,email',
                'ident_num'         =>  'required|numeric|unique:beneficiaries,ident_num',
                'num_f_members'     =>  'required|numeric|min:1',
                'neighborhood'      =>  'required|string||exists:neighborhoods,name',
                'ident_img'         =>  'required|mimes:jpg,jpeg,png|max:20000',
                'verification_code' =>  'required|same:code',
            ]);
            $data = $request->except('verification_code', 'code');

            // ident_img
            $ident_img  = $request->file('ident_img');
            $filename   = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $ident_img->getClientOriginalExtension();
            $path       = storage_path('app/public/uploads/beneficiaries/' . $filename);
            Image::make($ident_img->getRealPath())->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $data['ident_img'] = $filename;

            Beneficiary::create($data);
            session()->flash('sessionSuccess', 'تم إرسال طلبك بنجاح، وسيتم التواصل معكم في أقرب وقت ممكن!');
            return redirect()->back();
        }
        elseif($slug == 'donor_membership')
        {
            $data = $request->validate([
                'phone'     =>  'required|numeric|regex:/^(9665)([0-9]{8})$/|unique:donors,phone',
                'name'      =>  'required|string|min:3',
                'gender'    =>  'sometimes|nullable|in:male,female',
                'email'     =>  'required|email|max:255|unique:donors,email',
            ]);
            $data['status'] = 'inactive';
            Donor::create($data);
            session()->flash('sessionSuccess', 'تم إرسال طلبك بنجاح، وسيتم التواصل معكم في أقرب وقت ممكن!');
            return redirect()->back();
        } else {
            return redirect()->route('frontend.home');
        }
    }

    /*******
     *
     * ------ Certificate of General Assembly Member ------
     *
    */

    public function certificateOfGeneralAssemblyMember($uuid)
    {
        $member = GeneralAssemblyMember::whereUuid($uuid)->active()->first();
        if ($member) {
            return view('frontend.pages.certificate-of-general-assembly-member', compact('member'));
        }
        return abort(404);
    }
}
