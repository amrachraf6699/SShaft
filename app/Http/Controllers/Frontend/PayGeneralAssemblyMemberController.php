<?php

namespace App\Http\Controllers\Frontend;

use App\Account;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\GeneralAssemblyMember;
use App\GeneralAssemblyInvoice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Events\GeneralAssemblyMemberPaymentConfirm;
use App\Traits\SendSmsToTheGeneralAssemblyMember;

class PayGeneralAssemblyMemberController extends Controller
{
    use SendSmsToTheGeneralAssemblyMember;
    /**
     *
     * Choose payment method
     *
     */
    public function viewChoosePaymentMethod($uuid, $invoice_no)
    {
        $member  = GeneralAssemblyMember::whereUuid($uuid)->first();
        $invoice = GeneralAssemblyInvoice::whereInvoiceNo($invoice_no)->unpaid()->first();
        if ($member && $invoice) {
            // PAYMENT PROVIDER
            if(request('id') && request('resourcePath')) {
                $res            = session()->get(request('session_name'));
                $payment_status = $this->getPaymentStatus(request('id'), request('resourcePath'));
                $result_code    = $payment_status['result']['code'];

                if (($result_code == '000.100.110' || $result_code == '000.000.000' || $result_code == '000.300.000') && isset($payment_status['merchantTransactionId']) && !empty($payment_status['merchantTransactionId'])) { // success payment id >> transaction bank id
                    $showSuccessPaymentMessage = true;
                    // save transaction in donation table with transaction id  = $payment_status['id]
                    $invoiceData = [
                        'total_amount'          => $payment_status['amount'],
                        'bank_transaction_id'   => $payment_status['merchantTransactionId'],
                        'payment_brand'         => $payment_status['paymentBrand'],
                        'invoice_status'        => 'paid',
                        'payment_ways'          => 'credit_card',
                    ];

                    try {
                        DB::beginTransaction();
                            $invoice->update($invoiceData);
                            $member->update(['status' => 'active']);

                            // Send Email
                            $invoice = [
                                'member_uuid'           => $member->uuid,
                                'member_name'           => $member->full_name,
                                'member_email'          => $member->email,
                                'member_membership_no'  => $member->membership_no,
                                'member_phone'          => $member->phone,
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

                    session()->flash('sessionSuccess', 'تمت العملية بنجاح، ستصلكم منا رسالة برابط الفاتورة وتفاصيل العضوية، نشكر لكم ثقتكم بجمعية البر بجدة!');
                    return redirect()->route('general-assembly-member-invoice.show', [$invoice['invoice_no'], $member->uuid]);
                } else {
                    $showFailPaymentMessage = true;
                    session()->flash('sessionError', 'فشلت عملية الدفع، الرجاء التحقق وإعادة المحاولة!');
                    return redirect()->route('frontend.pay-general-assembly-members.choose-payment-method.view', [$member->uuid, $invoice->invoice_no]);
                }
            }

            return view('frontend.pay-general-assembly-members.choose-payment-method', compact('member', 'invoice'));
        }
        return abort(404);
    }

    public function storeChoosePaymentMethod(Request $request, $uuid, $invoice_no)
    {
        $member  = GeneralAssemblyMember::whereUuid($uuid)->first();
        $invoice = GeneralAssemblyInvoice::whereInvoiceNo($invoice_no)->unpaid()->first();
        if ($member && $invoice) {
            if ($request->payment_ways == 'bank_transfer') {
                return redirect()->route('frontend.pay-general-assembly-members.bank-transfer.view', [$member->uuid, $invoice->invoice_no]);
            }
            return redirect()->route('frontend.home');
        }
        return abort(404);
    }

    /***
     *
     * BANK TRANSFER
     */
    public function viewBankTransfer($uuid, $invoice_no)
    {
        $member  = GeneralAssemblyMember::whereUuid($uuid)->first();
        $invoice = GeneralAssemblyInvoice::whereInvoiceNo($invoice_no)->unpaid()->first();
        if ($member && $invoice) {
            $pageTitle      = __('translation.bank_transfer');
            $accounts = Account::query()->orderBy('id', 'DESC')->active()->get();
            return view('frontend.pay-general-assembly-members.bank-transfer', compact('member', 'invoice', 'pageTitle', 'accounts'));
        }
        return abort(404);
    }

    public function storeBankTransfer(Request $request, $uuid, $invoice_no)
    {
        $member  = GeneralAssemblyMember::whereUuid($uuid)->first();
        $invoice = GeneralAssemblyInvoice::whereInvoiceNo($invoice_no)->unpaid()->first();
        if ($member && $invoice) {
            // validate
            $data = $request->validate([
                'bank_name'     => 'required|exists:accounts,bank_name|string',
                'attachments'   => 'required|mimes:jpg,jpeg,png|max:20000'
            ],[],[
                'bank_name'     => trans('translation.bank_name'),
                'attachments'   => trans('translation.transfer_receipt'),
            ]);

            // transfer receipt
            $attachment     = $request->file('attachments');
            $filename       = 'IMG_' . rand(9999, 9999999) . Str::slug($invoice->invoice_no, '_') . '_' . time() . '.' . $attachment->getClientOriginalExtension();
            $path           = storage_path('app/public/uploads/transfer_receipts/' . $filename);
            Image::make($attachment->getRealPath())->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path, 100);
            $data['attachments']    = $filename;
            $data['payment_ways']   = 'bank_transfer';
            $data['invoice_status'] = 'awaiting_verification';

            $invoice->update($data);

            session()->flash('sessionSuccess', 'تمت العملية بنجاح، سيتم مراجعة طلبكم والتواصل معكم في أقرب وقت ممكن!');
            return redirect()->route('general-assembly-member-invoice.show', [$invoice->invoice_no, $member->uuid]);
        }
        return abort(404);
    }

    /**
     *
     * Get Payment Status
     *
     * */
    private function getPaymentStatus($id, $resourcePath)
    {
        $res  = session()->get(request('session_name'));
        if ($res['payment_brand'] == 'MADA') {
            $entity_id = config('payment_information.hyperpay.entityIdMADA');
        } elseif ($res['payment_brand'] == 'APPLEPAY') {
            $entity_id = config('payment_information.hyperpay.entityIdApplePay');
        } else {
            $entity_id = config('payment_information.hyperpay.entityIdVisaMaster');
        }

        $url = config('payment_information.hyperpay.get_status_link');
        $url .= $resourcePath;
        $url .= "?entityId=" . $entity_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        config('payment_information.hyperpay.authorization')));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }
}
