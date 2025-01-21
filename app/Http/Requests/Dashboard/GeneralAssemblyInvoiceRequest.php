<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class GeneralAssemblyInvoiceRequest extends FormRequest
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
            'invoice_status'    => 'required|in:paid,unpaid,awaiting_verification',
        ];
    }

    public function attributes()
    {
        return [
            'invoice_status'    =>  trans('translation.invoice_status'),
        ];
    }
}
