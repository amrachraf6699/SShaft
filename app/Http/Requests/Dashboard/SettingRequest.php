<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'name'              =>  'required|string|min:2',
            'address'           =>  'sometimes|nullable|string|min:5',
            'link_map_address'  =>  'sometimes|nullable',
            'description'       =>  'required|string|min:50',
            'keywords'          =>  'required|string|min:50',
            'email'             =>  'required|email',
            'logo'              =>  'sometimes|nullable|mimes:jpg,jpeg,png|max:20000',
            'fav'               =>  'sometimes|nullable|mimes:jpg,jpeg,png|max:20000',
            'phone'             =>  'required',
        ];
    }

    public function attributes()
    {
        return [
            'name'              =>  trans('dashboard.site_name'),
            'address'           =>  trans('dashboard.address'),
            'link_map_address'  =>  trans('dashboard.link_map_address'),
            'description'       =>  trans('dashboard.description'),
            'keywords'          =>  trans('dashboard.keywords'),
            'email'             =>  trans('dashboard.email'),
            'logo'              =>  'sometimes|nullable|mimes:jpg,jpeg,png|max:20000',
            'fav'               =>  'sometimes|nullable|mimes:jpg,jpeg,png|max:20000',
            'phone'             =>  trans('dashboard.phone'),
        ];
    }
}
