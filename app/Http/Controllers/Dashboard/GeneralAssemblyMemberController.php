<?php

namespace App\Http\Controllers\Dashboard;

use App\Package;
use Illuminate\Http\Request;
use App\GeneralAssemblyMember;
use App\GeneralAssemblyInvoice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Events\GeneralAssemblyMemberCreated;
use App\Traits\SendSmsToTheGeneralAssemblyMember;
use App\Http\Requests\Dashboard\GeneralAssemblyMemberRequest;

class GeneralAssemblyMemberController extends Controller
{
    use SendSmsToTheGeneralAssemblyMember;

    public function __construct()
    {
        $this->middleware(['permission:read_general_assembly_members'])->only(['index', 'show']);
        $this->middleware(['permission:create_general_assembly_members'])->only('create');
        $this->middleware(['permission:update_general_assembly_members'])->only('edit');
        $this->middleware(['permission:delete_general_assembly_members'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $status         = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $package_id     = (isset(\request()->package_id) && \request()->package_id != '') ? \request()->package_id : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $members = GeneralAssemblyMember::query()->with('package:id,title');

        if ($keyword != null) {
            $members = $members->search($keyword);
        }

        if ($status != null) {
            $members = $members->whereStatus($status);
        }

        $members = $members->orderBy($sort_by, $order_by);
        $members = $members->paginate($limit_by);
        return view('dashboard.general-assembly-members.index', compact('members'));
    }

    public function create()
    {
        $packages = Package::orderBy('id', 'DESC')->active()->pluck('title', 'id');
        return view('dashboard.general-assembly-members.create', compact('packages'));
    }

    public function store(GeneralAssemblyMemberRequest $request)
    {
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
                $data['attachments'] = $filename;

                $member = GeneralAssemblyMember::create($data);

                /**
                 * CREATE INVOICE TO GENERAL ASSEMBLY MEMBER
                 */
                $invoice = new GeneralAssemblyInvoice();
                $invoice->general_assembly_member_id    = $member->id;
                $invoice->total_amount                  = $member->package->price;
                $invoice->payment_ways                  = $member->payment_ways;
                $invoice->subscription_date             = $member->subscription_date;
                $invoice->expiry_date                   = $member->expiry_date;
                $invoice->save();

                if ($request->send_invoice == 'yes') {
                    $member = [
                        'uuid'              => $member->uuid,
                        'name'              => $member->full_name,
                        'status'            => $member->status,
                        'email'             => $member->email,
                        'phone'             => $member->phone,
                        'membership_no'     => $member->membership_no,
                        'invoice_no'        => $invoice->invoice_no,
                        'subscription_date' => $invoice->subscription_date,
                        'expiry_date'       => $invoice->expiry_date,
                        'total_amount'      => $invoice->total_amount,
                        'payment_ways'      => $invoice->payment_ways,
                    ];

                    // send SMS to member
                    $this->register($member['phone'], $member);
                    // send email to member
                    GeneralAssemblyMemberCreated::dispatch($member);
                    event(new GeneralAssemblyMemberCreated($member));
                }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        session()->flash('success', __('dashboard.added_successfully'));
        return redirect()->route('dashboard.general-assembly-members.index');
    }

    public function show($id)
    {
        $member = GeneralAssemblyMember::whereId($id)->first();
        if ($member) {
            $invoice = GeneralAssemblyInvoice::whereGeneralAssemblyMemberId($member->id)->first();
            if ($invoice) {
                return redirect()->route('general-assembly-member-invoice.show', [$invoice->invoice_no, $member->uuid]);
            } else {
                $invoice = new GeneralAssemblyInvoice();
                $invoice->general_assembly_member_id    = $member->id;
                $invoice->total_amount                  = $member->package->price;
                $invoice->payment_ways                  = $member->payment_ways;
                $invoice->save();

                session()->flash('success', __('dashboard.added_successfully'));
                return redirect()->route('dashboard.general-assembly-members.index');
            }
        }
        return redirect()->route('dashboard.general-assembly-members.index');
    }

    public function edit($id)
    {
        $member = GeneralAssemblyMember::whereId($id)->first();
        if ($member) {
            $packages = Package::orderBy('id', 'DESC')->active()->pluck('title', 'id');
            return view('dashboard.general-assembly-members.edit', compact('member', 'packages'));
        }
        return redirect()->route('dashboard.general-assembly-members.index');
    }

    public function update(Request $request, $id)
    {
        $member = GeneralAssemblyMember::whereId($id)->first();
        if ($member) {
            $data = $request->validated();
            return $data;
            // attachments
            if ($attachments  = $request->file('attachments')) {
                Storage::disk('public')->delete('/general_assembly_members/' . $member->img);
                $filename       = 'IMG_' . time() . '_' . rand(1, 999999) . '.' . $attachments->getClientOriginalExtension();
                $path           = storage_path('app/public/uploads/general_assembly_members/' . $filename);
                Image::make($attachments->getRealPath())->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($path, 100);
                $data['attachments'] = $filename;
            }

            $member->update($data);
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->route('dashboard.general-assembly-members.index');
        }
        return redirect()->route('dashboard.general-assembly-members.index');
    }

    public function destroy($id)
    {
        $member = GeneralAssemblyMember::whereId($id)->first();
        if($member) {
            Storage::disk('public')->delete('/general_assembly_members/' . $member->attachments);
            $member->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.general-assembly-members.index');
        }
        return redirect()->route('dashboard.general-assembly-members.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $members = GeneralAssemblyMember::select('id', 'attachments')->whereIn('id', $ids)->get();
        if ($members) {
            foreach ($members as $member) {
                Storage::disk('public')->delete('/general_assembly_members/' . $member->attachments);
                $member->delete();
            }
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.general-assembly-members.index');
    }

    public function changeStatus(Request $request, $id)
    {
        $member  = GeneralAssemblyMember::whereId($id)->first();
        $invoice = GeneralAssemblyInvoice::whereGeneralAssemblyMemberId($member->id)->first();

        if ($member && $invoice) {
            $data = $request->validate(['status' => 'required|in:active,pending,inactive,awaiting_payment,rejected']);
            $member->status = $data['status'];
            $member->save();
            $member = [
                'uuid'              => $member->uuid,
                'name'              => $member->full_name,
                'status'            => $member->status,
                'email'             => $member->email,
                'phone'             => $member->phone,
                'membership_no'     => $member->membership_no,
                'invoice_no'        => $invoice->invoice_no,
                'subscription_date' => $invoice->subscription_date,
                'expiry_date'       => $invoice->expiry_date,
                'total_amount'      => $invoice->total_amount,
                'payment_ways'      => $invoice->payment_ways,
            ];

            // send SMS to member
            $this->register($member['phone'], $member);
            // send email to member
            event(new GeneralAssemblyMemberCreated($member));
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.general-assembly-members.index');
    }
}
