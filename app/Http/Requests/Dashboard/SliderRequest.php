<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
                'title'             =>  'required|string',
                // 'button'            =>  'required|string',
                'url'               =>  'sometimes|nullable|url',
                'status'            =>  'required|in:active,inactive',
                'quick_donation'    =>  'required|in:yes,no',
                'service_id'        =>  'required_if:quick_donation,yes|sometimes|nullable|exists:services,id|integer',
                'img'               =>  'required|mimes:jpg,jpeg,png|max:20000',
                'type'              =>  'nullable',
                'branch_id'         =>  'required',

            ];
        } else {
            return [
                'title'             =>  'required|string',
                // 'button'            =>  'required|string',
                'url'               =>  'sometimes|nullable|url',
                'status'            =>  'required|in:active,inactive',
                'quick_donation'    =>  'required|in:yes,no',
                'service_id'        =>  'required_if:quick_donation,yes|sometimes|nullable|exists:services,id|integer',
                'img'               =>  'sometimes|required|mimes:jpg,jpeg,png|max:20000',
                'type'              =>  'nullable',
                'branch_id'         =>  'required',
            ];
        }
    }

    public function attributes()
    {
        return [
            'title'             =>  trans('dashboard.title'),
            'button'            =>  trans('dashboard.button'),
            'url'               =>  trans('dashboard.url'),
            'img'               =>  trans('dashboard.img'),
            'quick_donation'    =>  trans('translation.quick_donation_form'),
            'service_id'        =>  trans('translation.service'),
            'branch_id'         =>  trans('dashboard.branch_ids'),
        ];
    }
}
