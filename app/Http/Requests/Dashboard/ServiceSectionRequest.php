<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ServiceSectionRequest extends FormRequest
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
                'title'     =>  'required|string|unique:service_sections,title',
                'status'    =>  'required|in:active,inactive',
                'parent_id' =>  'nullable',
                'desc'      =>  'nullable'
            ];
        } else {
            return [
                'title'     =>  'required|string|unique:service_sections,title,'.$this->service_section,
                'status'    =>  'required|in:active,inactive',
                'parent_id' =>  'nullable',
                'desc'      =>  'nullable'
            ];
        }
    }

    public function attributes()
    {
        return [
            'title'     =>  trans('dashboard.title'),
            'status'    =>  trans('dashboard.status'),
        ];
    }
}
