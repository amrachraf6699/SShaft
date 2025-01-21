<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
                'title'     =>  'required|string|unique:packages,title',
                'price'     =>  'required|numeric',
            ];
        } else {
            return [
                'title'     =>  'required|string|unique:packages,title,'.$this->package,
                'price'     =>  'required|numeric',
            ];
        }
    }

    public function attributes()
    {
        return [
            'title'     =>  trans('dashboard.title'),
            'price'     =>  trans('dashboard.price'),
        ];
    }
}
