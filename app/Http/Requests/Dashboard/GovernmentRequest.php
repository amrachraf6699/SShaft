<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class GovernmentRequest extends FormRequest
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
                'title'             =>  'required|string|unique:governments,title',
                'content'           =>  'sometimes|nullable|string',
                'status'            =>  'required|in:active,inactive',
                'file'              =>  'sometimes|nullable|mimes:pdf|max:20000',
            ];
        } else {
            return [
                'title'             =>  'required|string|unique:governments,title,'.$this->government,
                'content'           =>  'sometimes|nullable|string',
                'status'            =>  'required|in:active,inactive',
                'file'              =>  'sometimes|nullable|mimes:pdf|max:20000',
            ];
        }
    }

    public function attributes()
    {
        return [
            'title'             =>  trans('dashboard.title'),
            'content'           =>  trans('dashboard.content'),
            'status'            =>  trans('dashboard.status'),
            'file'              =>  trans('translation.file'),
        ];
    }
}
