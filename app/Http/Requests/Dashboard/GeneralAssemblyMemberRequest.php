<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class GeneralAssemblyMemberRequest extends FormRequest
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
                'package_id'        =>  'required|exists:packages,id|integer',
                'first_name'        =>  'required|string|min:3',
                'last_name'         =>  'required|string|min:3',
                'gender'            =>  'sometimes|nullable|in:male,female',
                'email'             =>  'required|email|max:50|unique:general_assembly_members,email',
                'phone'             =>  'required|numeric|regex:/^(05)([0-9]{8})$/|unique:general_assembly_members,phone',
                'payment_ways'      =>  'required|in:bank_transfer,credit_card',
                'status'            =>  'required|in:active,pending,awaiting_payment,inactive',
                'ident_num'         =>  'required|numeric|digits:10|unique:general_assembly_members,ident_num',
                'subscription_date' =>  'required|date',
                'attachments'       =>  'required|mimes:jpg,jpeg,png|max:20000',
            ];
        } else {
            return [
                'package_id'        =>  'required|exists:packages,id|integer',
                'first_name'        =>  'required|string|min:3',
                'last_name'         =>  'required|string|min:3',
                'gender'            =>  'sometimes|nullable|in:male,female',
                'email'             =>  'required|email|max:50|unique:general_assembly_members,email,'.$this->general_assembly_member,
                'phone'             =>  'required|numeric|regex:/^(05)([0-9]{8})$/|unique:general_assembly_members,phone,'.$this->general_assembly_member,
                'ident_num'         =>  'required|numeric|digits:10|unique:general_assembly_members,ident_num,'.$this->general_assembly_member,
                'subscription_date' =>  'required|date',
                'attachments'       =>  'sometimes|mimes:jpg,jpeg,png|max:20000',
            ];
        }
    }

    public function attributes()
    {
        return [
            'package_id'            =>  trans('translation.package_id'),
            'first_name'            =>  trans('translation.first_name'),
            'last_name'             =>  trans('translation.last_name'),
            'gender'                =>  trans('translation.gender'),
            'email'                 =>  trans('dashboard.email'),
            'phone'                 =>  trans('dashboard.phone'),
            'payment_ways'          =>  trans('translation.payment_ways'),
            'status'                =>  trans('dashboard.status'),
            'ident_num'             =>  trans('translation.ident_num'),
            'subscription_date'     =>  trans('translation.subscription_date'),
            'attachments'           =>  trans('translation.ident_attachment'),
        ];
    }
}
