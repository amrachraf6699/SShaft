<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class BeneficiaryRequest extends FormRequest
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
            'phone'             =>  ['required', 'regex:/^((9665)|(05))[0-9]{8}$/', 'unique:beneficiaries,phone'],
            'name'              =>  'required|string|min:3',
            'email'             =>  'sometimes|nullable|email|max:191',
            'ident_num'         =>  'required|numeric|unique:beneficiaries,ident_num',
            'num_f_members'     =>  'required|numeric|min:1',
            'neighborhood'      =>  'required|string||exists:neighborhoods,name',
            'ident_img'         =>  'required|mimes:jpg,jpeg,png|max:20000',
            'verification_code' =>  'required|same:code',
        ];
    }
}
