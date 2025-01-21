<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        // $rules = [
        //     'name'          => 'required|unique:roles',
        //     'permissions'   => 'required',
        // ];

        // if (in_array($this->method(), ['PUT', 'PATCH'])) {

        //     $role = $this->route()->parameter('group');

        //     $rules['name'] = 'required|unique:roles,id,' . $role->id;

        // }

        // return $rules;

        if ($this->isMethod('POST')) {
            return [
                'name'          =>  'required|string|unique:roles,name',
                'permissions'   => 'required',
            ];
        } else {
            return [
                'name'          =>  'required|string|unique:roles,name,'.$this->role,
                'permissions'   => 'required',
            ];
        }
    }

    public function attributes()
    {
        return [
            'name'     =>  trans('dashboard.name'),
            'name'     =>  trans('dashboard.permissions'),
        ];
    }
}
