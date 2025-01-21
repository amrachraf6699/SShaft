<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UserGroupRequest extends FormRequest
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
                'title'     =>  'required|string|unique:user_groups,title',
            ];
        } else {
            return [
                'title'     =>  'required|string|unique:user_groups,title,'.$this->user_group,
            ];
        }
    }

    public function attributes()
    {
        return [
            'title'     =>  trans('dashboard.title'),
        ];
    }
}
