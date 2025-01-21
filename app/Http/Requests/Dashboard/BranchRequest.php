<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
                'name'              =>  'required|string|unique:branches,name',
                'content'           =>  'required|string|min:10',
                'link_map_address'  =>  'required|string',
                'status'            =>  'required|in:active,inactive',
            ];
        } else {
            return [
                'name'              =>  'required|string|unique:branches,name,'.$this->branch,
                'content'           =>  'required|string|min:10',
                'link_map_address'  =>  'required|string',
                'status'            =>  'required|in:active,inactive',
            ];
        }
    }

    public function attributes()
    {
        return [
            'name'              =>  trans('dashboard.name'),
            'content'           =>  trans('dashboard.content'),
            'link_map_address'  =>  trans('dashboard.link_map_address'),
            'status'            =>  trans('dashboard.status'),
        ];
    }
}
