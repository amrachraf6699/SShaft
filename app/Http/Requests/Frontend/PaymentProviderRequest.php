<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class PaymentProviderRequest extends FormRequest
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
            'quantity'      => 'required|numeric|gt:0',
            'phoneNumber'   => ['required', 'regex:/^((9665)|(05))[0-9]{8}$/'],
            'payment_brand' => 'required|in:credit_card,VISA MASTER,APPLEPAY,MADA',
            'serviceId'     => 'required|exists:services,id|integer',
        ];
    }

    public function attributes()
    {
        return [
            'total_amount'  => __('dashboard.total_amount'),
            'quantity'      => __('dashboard.quantity'),
            'phoneNumber'   => __('dashboard.phone'),
            'payment_brand' => __('translation.payment_ways'),
            'serviceId'     => __('translation.service'),
        ];
    }
}
