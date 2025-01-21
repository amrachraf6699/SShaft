<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class NeighborhoodRequest extends FormRequest
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
                'name'      =>  'required|string|unique:neighborhoods,name',
                'status'    =>  'required|in:active,inactive',
            ];
        } else {
            return [
                'name'      =>  'required|string|unique:neighborhoods,name,'.$this->neighborhood,
                'status'    =>  'required|in:active,inactive',
            ];
        }
    }

    public function attributes()
    {
        return [
            'name'      =>  trans('dashboard.name'),
            'status'    =>  trans('dashboard.status'),
        ];
    }
}
