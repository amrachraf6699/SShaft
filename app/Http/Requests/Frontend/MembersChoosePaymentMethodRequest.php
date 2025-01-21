<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class MembersChoosePaymentMethodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'total_amount'  => 'required|numeric|gt:0',
            'invoice_no'    => 'required|exists:general_assembly_invoices,invoice_no|string',
            'member_uuid'   => 'required|exists:general_assembly_members,uuid|uuid',
            'payment_brand' => 'required|in:credit_card,VISA MASTER,APPLEPAY,MADA',
        ];
    }

    public function attributes()
    {
        return [
            'total_amount'  => __('dashboard.total_amount'),
            'invoice_no'    => __('translation.invoice_no'),
            'member_uuid'   => __('translation.member_uuid'),
            'payment_brand' => __('translation.payment_ways'),
        ];
    }
}
