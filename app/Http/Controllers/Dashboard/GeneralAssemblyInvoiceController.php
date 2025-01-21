<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\GeneralAssemblyInvoice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\SendSmsToTheGeneralAssemblyMember;
use App\Events\GeneralAssemblyMemberPaymentConfirm;
use App\Http\Requests\Dashboard\GeneralAssemblyInvoiceRequest;

class GeneralAssemblyInvoiceController extends Controller
{
    use SendSmsToTheGeneralAssemblyMember;

    public function __construct()
    {
        $this->middleware(['permission:read_invoices'])->only(['index', 'show']);
        $this->middleware(['permission:create_invoices'])->only('create');
        $this->middleware(['permission:update_invoices'])->only('edit');
        $this->middleware(['permission:delete_invoices'])->only(['destroy', 'multiDelete']);
    }

    public function index()
    {
        $keyword        = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $invoice_status = (isset(\request()->invoice_status) && \request()->invoice_status != '') ? \request()->invoice_status : null;
        $payment_ways   = (isset(\request()->payment_ways) && \request()->payment_ways != '') ? \request()->payment_ways : null;
        $sort_by        = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by       = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'DESC';
        $limit_by       = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $invoices = GeneralAssemblyInvoice::query()->with('general_assembly_member');

        if ($keyword != null) {
            $invoices = $invoices->search($keyword);
        }

        if ($invoice_status != null) {
            $invoices = $invoices->whereInvoiceStatus($invoice_status);
        }

        if ($payment_ways != null) {
            $invoices = $invoices->wherePaymentWays($payment_ways);
        }

        $invoices = $invoices->orderBy($sort_by, $order_by);
        $invoices = $invoices->paginate($limit_by);
        return view('dashboard.general-assembly-invoices.index', compact('invoices'));
    }

    public function edit($id)
    {
        $invoice = GeneralAssemblyInvoice::whereId($id)->first();
        if ($invoice) {
            return view('dashboard.general-assembly-invoices.edit', compact('invoice'));
        }
        return redirect()->route('dashboard.general-assembly-invoices.index');
    }

    public function update(GeneralAssemblyInvoiceRequest $request, $id)
    {
        $invoice = GeneralAssemblyInvoice::whereId($id)->with('general_assembly_member')->first();
        if ($invoice) {
            if ($request->invoice_status != $invoice->invoice_status) {
                try {
                    DB::beginTransaction();
                        $invoice->invoice_status = $request->invoice_status;
                        $invoice->save();

                        if ($request->invoice_status == 'paid') {
                            $invoice->general_assembly_member->status = 'active';
                            $invoice->general_assembly_member->save();
                        } elseif ($request->invoice_status == 'unpaid') {
                            $invoice->general_assembly_member->status = 'pending';
                            $invoice->general_assembly_member->save();
                        } elseif ($request->invoice_status == 'awaiting_verification') {
                            $invoice->general_assembly_member->status = 'awaiting_payment';
                            $invoice->general_assembly_member->save();
                        }

                        // ..
                        $invoice = [
                            'member_uuid'           => $invoice->general_assembly_member->uuid,
                            'member_name'           => $invoice->general_assembly_member->full_name,
                            'member_email'          => $invoice->general_assembly_member->email,
                            'member_phone'          => $invoice->general_assembly_member->phone,
                            'member_membership_no'  => $invoice->general_assembly_member->membership_no,
                            'invoice_no'            => $invoice->invoice_no,
                            'invoice_status'        => $invoice->invoice_status,
                            'subscription_date'     => $invoice->subscription_date,
                            'expiry_date'           => $invoice->expiry_date,
                            'total_amount'          => $invoice->total_amount,
                            'payment_ways'          => $invoice->payment_ways,
                        ];

                        // send SMS to member
                        $this->confirm($invoice['member_phone'], $invoice);
                        // event(new GeneralAssemblyMemberPaymentConfirm($invoice));
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    throw $e;
                }

                session()->flash('success', __('dashboard.updated_successfully'));
                return redirect()->back();
            }
            session()->flash('success', __('dashboard.updated_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.general-assembly-invoices.index');
    }

    public function destroy($id)
    {
        $invoice = GeneralAssemblyInvoice::whereId($id)->first();
        if($invoice) {
            $invoice->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->route('dashboard.general-assembly-invoices.index');
        }
        return redirect()->route('dashboard.general-assembly-invoices.index');
    }

    public function multiDelete(Request $request)
    {
        $ids = explode(',', $request->ids);
        $invoices = GeneralAssemblyInvoice::select('id')->whereIn('id', $ids);
        if ($invoices) {
            $invoices->delete();
            session()->flash('success', __('dashboard.deleted_successfully'));
            return redirect()->back();
        }
        return redirect()->route('dashboard.general-assembly-invoices.index');
    }
}
