<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
                'title'                         =>  'required|string|unique:services,title',
                'service_section_id'            =>  'required|exists:service_sections,id|integer',
                'branch_id'                    =>  'nullable|exists:services,id|integer',
                'how_does_the_service_work'     =>  'required|string|min:20',
                'content'                       =>  'required|string|min:20',
                'quick_donation'                =>  'required|in:unlisted,included',
                'incoming_requests'             =>  'required|in:accept,not_accept',
                'price_value'                   =>  'required|in:fixed,variable,percent,multi',
                'target_value'                  =>  'required|numeric',
                'basic_service_value'           =>  'nullable',// 'required_if:price_value,fixed,percent|sometimes|nullable|numeric',
                'multiple_service_value_1'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'multiple_service_value_2'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'multiple_service_value_3'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'number_of_accepted_services'   =>  'required_if:price_value,fixed,variable,percent|sometimes|nullable|integer',
                'status'                        =>  'required|in:active,inactive',
                'img'                           =>  'required|mimes:jpg,jpeg,png|max:20000',
                'app_icon'                      =>  'required|mimes:jpg,jpeg,png,svg|max:20000',
                'cover'                         =>  'required|mimes:jpg,jpeg,png,svg|max:20000',
                'viewpercent'                  =>  'nullable',
            ];
        } else {
            return [
                'title'                         =>  'required|string|unique:services,title,'.$this->service,
                'service_section_id'            =>  'required|exists:service_sections,id|integer',
                'how_does_the_service_work'     =>  'required|string|min:20',
                'content'                       =>  'required|string|min:20',
                'quick_donation'                =>  'required|in:unlisted,included',
                'incoming_requests'             =>  'required|in:accept,not_accept',
                'price_value'                   =>  'required|in:fixed,variable,percent,multi',
                'target_value'                  =>  'required|numeric',
                'basic_service_value'           =>  'nullable',// 'required_if:price_value,fixed,percent|sometimes|nullable|numeric',
                'multiple_service_value_1'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'multiple_service_value_2'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'multiple_service_value_3'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'number_of_accepted_services'   =>  'required_if:price_value,fixed,variable,percent|sometimes|nullable|integer',
                'status'                        =>  'required|in:active,inactive',
                'img'                           =>  'sometimes|mimes:jpg,jpeg,png|max:20000',
                'app_icon'                      =>  'sometimes|mimes:jpg,jpeg,png,svg|max:20000',
                'cover'                         =>  'sometimes|mimes:jpg,jpeg,png,svg|max:20000',
                'viewpercent'                  =>  'nullable',
            ];
        }
    }

    public function attributes()
    {
        return [
            'title'                         =>  trans('dashboard.title'),
            'service_section_id'            =>  trans('translation.section'),
            'how_does_the_service_work'     =>  trans('translation.how_does_the_service_work'),
            'content'                       =>  trans('dashboard.content'),
            'quick_donation'                =>  trans('translation.quick_donation'),
            'incoming_requests'             =>  trans('translation.incoming_requests'),
            'price_value'                   =>  trans('translation.price_value'),
            'basic_service_value'           =>  trans('translation.basic_service_value'),
            'multiple_service_value_1'      =>  trans('translation.multiple_service_value_1'),
            'multiple_service_value_2'      =>  trans('translation.multiple_service_value_2'),
            'multiple_service_value_3'      =>  trans('translation.multiple_service_value_3'),
            'number_of_accepted_services'   =>  trans('translation.number_of_accepted_services'),
            'target_value'                  =>  trans('translation.target_value'),
            'status'                        =>  trans('dashboard.status'),
            'img'                           =>  trans('dashboard.img'),
            'app_icon'                      =>  trans('translation.icon_app'),
        ];
    }
}
