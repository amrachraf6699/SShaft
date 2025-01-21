<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
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
                'name'      =>  'required|string|min:5|unique:partners,name',
                'content'   =>  'sometimes|nullable|string|min:20',
                'status'    =>  'required|in:active,inactive',
                'url'       =>  'sometimes|nullable|url',
                'img'       =>  'required|mimes:jpg,jpeg,png|max:20000',
            ];
        } else {
            return [
                'name'      =>  'required|string|min:5|unique:partners,name,'.$this->partner,
                'content'   =>  'sometimes|nullable|string|min:20',
                'status'    =>  'required|in:active,inactive',
                'url'       =>  'sometimes|nullable|url',
                'img'       =>  'sometimes|required|mimes:jpg,jpeg,png|max:20000',
            ];
        }
    }

    public function attributes()
    {
        return [
            'name'      =>  trans('dashboard.name'),
            'content'   =>  trans('dashboard.content'),
            'url'       =>  trans('dashboard.url'),
            'status'    =>  trans('dashboard.status'),
            'img'       =>  trans('dashboard.img'),
        ];
    }
}
