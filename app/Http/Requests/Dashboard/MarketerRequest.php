<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class MarketerRequest extends FormRequest
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
                'first_name'            =>  'required|string|min:3|max:191',
                'last_name'             =>  'required|string|min:3|max:191',
                'status'                =>  'required|in:active,inactive',
                'marketer_permissions'  =>  'sometimes|nullable|array',
            ];
        } else {
            return [
                'first_name'            =>  'required|string|min:3|max:191',
                'last_name'             =>  'required|string|min:3|max:191',
                'status'                =>  'required|in:active,inactive',
                'marketer_permissions'  =>  'sometimes|nullable|array',
            ];
        }
    }

    public function attributes()
    {
        return [
            'first_name'            =>  trans('translation.first_name'),
            'last_name'             =>  trans('translation.last_name'),
            'status'                =>  trans('dashboard.status'),
            'marketer_permissions'  =>  trans('translation.sections'),
        ];
    }
}
