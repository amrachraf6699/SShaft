<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
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
                'title'     =>  'required|string|unique:surveys,title',
                'status'    =>  'required|in:active,inactive',
            ];
        } else {
            return [
                'title'     =>  'required|string|unique:surveys,title,'.$this->surveys,
                'status'    =>  'required|in:active,inactive',
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
