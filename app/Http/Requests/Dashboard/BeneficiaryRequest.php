<?php

namespace App\Http\Requests\Dashboard;

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
        if ($this->isMethod('POST')) {
            return [
                'phone'             =>  ['required', 'regex:/^((9665)|(05))[0-9]{8}$/', 'unique:beneficiaries,phone'],
                'name'              =>  'required|string|min:3',
                'email'             =>  'sometimes|nullable|email|max:191',
                'ident_num'         =>  'required|numeric|unique:beneficiaries,ident_num',
                'num_f_members'     =>  'required|numeric|min:1',
                'neighborhood'      =>  'required|string||exists:neighborhoods,id',
                'ident_img'         =>  'required|mimes:jpg,jpeg,png|max:20000',

                'title'                         =>  'required|string|unique:services,title',
                'service_section_id'            =>  'required|exists:service_sections,id|integer',
                'how_does_the_service_work'     =>  'sometimes|nullable|string|min:20',
                'content'                       =>  'required|string|min:20',
                // 'quick_donation'                =>  'required|in:unlisted,included',
                // 'incoming_requests'             =>  'required|in:accept,not_accept',
                'publish_status'                =>  'required|in:fixed,hide,show',
                'price_value'                   =>  'required|in:fixed,variable,percent,multi',
                'target_value'                  =>  'required|numeric',
                'basic_service_value'           =>  'required_if:price_value,fixed,percent|sometimes|nullable|numeric',
                'multiple_service_value_1'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'multiple_service_value_2'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'multiple_service_value_3'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'number_of_accepted_services'   =>  'required_if:price_value,fixed,variable,percent|sometimes|nullable|integer',
                'img'                           =>  'required|mimes:jpg,jpeg,png|max:20000',
                'app_icon'                      =>  'required|mimes:jpg,jpeg,png,svg|max:20000',
            ];
        } else {
            return [
                'title'                         =>  'required|string|unique:services,title,'.$this->service,
                'service_section_id'            =>  'required|exists:service_sections,id|integer',
                'how_does_the_service_work'     =>  'sometimes|nullable|string|min:20',
                'content'                       =>  'required|string|min:20',
                // 'quick_donation'                =>  'required|in:unlisted,included',
                // 'incoming_requests'             =>  'required|in:accept,not_accept',
                'publish_status'                =>  'required|in:fixed,hide,show',
                'price_value'                   =>  'required|in:fixed,variable,percent,multi',
                'target_value'                  =>  'required|numeric',
                'basic_service_value'           =>  'required_if:price_value,fixed,percent|sometimes|nullable|numeric',
                'multiple_service_value_1'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'multiple_service_value_2'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'multiple_service_value_3'      =>  'required_if:price_value,multi|sometimes|nullable|numeric',
                'number_of_accepted_services'   =>  'required_if:price_value,fixed,variable,percent|sometimes|nullable|integer',
                'img'                           =>  'sometimes|mimes:jpg,jpeg,png|max:20000',
                'app_icon'                      =>  'sometimes|mimes:jpg,jpeg,png,svg|max:20000',
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
            'img'                           =>  trans('dashboard.img'),
            'app_icon'                      =>  trans('translation.icon_app'),
        ];
    }
}
