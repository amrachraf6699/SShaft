<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
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
                'title'             =>  'required|string|unique:modules,title',
                'module_section_id' =>  'required|exists:module_sections,id|integer',
                'content'           =>  'sometimes|nullable|string',
                'status'            =>  'required|in:active,inactive',
                'file'              =>  'sometimes|nullable|mimes:pdf|max:20000',
            ];
        } else {
            return [
                'title'             =>  'required|string|unique:modules,title,'.$this->module,
                'module_section_id' =>  'required|exists:module_sections,id|integer',
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
            'module_section_id' =>  trans('translation.section'),
            'content'           =>  trans('dashboard.content'),
            'status'            =>  trans('dashboard.status'),
            'file'              =>  trans('translation.file'),
        ];
    }
}
