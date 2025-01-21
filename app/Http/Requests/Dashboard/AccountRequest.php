<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
        if ($this->isMethod('POST')) {
            return [
                'bank_name'         =>  'required|string|unique:accounts,bank_name',
                'account_number'    =>  'required|numeric|unique:accounts,account_number',
                'IBAN'              =>  'required|string|unique:accounts,IBAN',
                'status'            =>  'required|in:active,inactive',
                'bank_link'         =>  'sometimes|nullable|url',
            ];
        } else {
            return [
                'bank_name'         =>  'required|string|unique:accounts,bank_name,'.$this->account,
                'account_number'    =>  'required|numeric|unique:accounts,account_number,'.$this->account,
                'IBAN'              =>  'required|string|unique:accounts,IBAN,'.$this->account,
                'status'            =>  'required|in:active,inactive',
                'bank_link'         =>  'sometimes|nullable|url',
            ];
        }
    }

    public function attributes()
    {
        return [
            'bank_name'         =>  trans('translation.bank_name'),
            'account_number'    =>  trans('translation.account_number'),
            'IBAN'              =>  trans('translation.IBAN'),
            'bank_link'         =>  trans('translation.bank_link'),
            'status'            =>  trans('dashboard.status'),
        ];
    }
}
