<?php

namespace App\Http\Controllers\Dashboard;

use App\Donation;
use Illuminate\Http\Request;
use App\GeneralAssemblyMember;
use App\GeneralAssemblyInvoice;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    public function showInvoice($donation_code)
    {
        $donation = Donation::whereDonationCode($donation_code)->first();
        if ($donation) {
            return view('donation-invoice', compact('donation'));
        }
        return abort(404);
    }

    public function showInvoiceGeneralAssemblyMember($invoice_no, $uuid)
    {
        $member  = GeneralAssemblyMember::whereUuid($uuid)->first();
        $invoice = GeneralAssemblyInvoice::whereInvoiceNo($invoice_no)->first();
        if ($member && $invoice) {
            return view('general-assembly-member-invoice', compact('invoice'));
        }
        return abort(404);
    }
}
