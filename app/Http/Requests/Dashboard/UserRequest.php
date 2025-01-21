<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                'name'          =>  'required|string|min:3',
                'email'         =>  'required|email|max:50|unique:users',
                'password'      =>  'required_with:confirm_password|same:confirm_password|min:8',
                // 'user_group_id' =>  'required|exists:user_groups,id|integer',
                'user_status'   =>  'required|in:active,inactive',
                'phone'         =>  'sometimes|nullable|numeric|regex:/^(9665)([0-9]{8})$/|unique:users,phone',
                'gender'        =>  'sometimes|nullable|in:male,female',
                'role_id'       => 'required',
                'branch_id'     => 'required'
            ];
        } else {
            return [
                'name'           =>  'required|string|min:3',
                'email'          =>  'required|email|max:50|unique:users,email,'.$this->user,
                'password'       =>  'sometimes|nullable|same:confirm_password|min:8',
                // 'user_group_id'  =>  'required|exists:user_groups,id|integer',
                'user_status'    =>  'required|in:active,inactive',
                'phone'          =>  'sometimes|nullable|numeric|regex:/^(9665)([0-9]{8})$/|unique:users,phone,'.$this->user,
                'gender'         =>  'sometimes|nullable|in:male,female',
                'role_id'        => 'required',
                'branch_id'     => 'required'
            ];
        }
    }

    public function attributes()
    {
        return [
            'name'          =>  trans('dashboard.name'),
            'email'         =>  trans('dashboard.email'),
            'password'      =>  trans('dashboard.password'),
            'user_group_id' =>  trans('translation.membership_type'),
            'user_status'   =>  trans('dashboard.user_status'),
            'phone'         =>  trans('dashboard.phone'),
            'gender'        =>  trans('translation.gender'),
            'permissions'   =>  trans('dashboard.u_permissions'),
        ];
    }
}
