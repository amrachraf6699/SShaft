<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ValidateDonorNumber extends FormRequest
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
        return [
            // 'phone' => 'required|regex:/^(9665)([0-9]{8})$/',
            'phone' => ['required', 'regex:/^((9665)|(05))[0-9]{8}$/']
        ];
    }
}
