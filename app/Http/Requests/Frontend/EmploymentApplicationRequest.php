<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class EmploymentApplicationRequest extends FormRequest
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
            'full_name'                 =>  'required|string|min:8',
            'age'                       =>  'sometimes|nullable|integer',
            'ident_num'                 =>  'sometimes|nullable|integer',
            'gender'                    =>  'sometimes|nullable|in:male,female',
            'email'                     =>  'required|email|max:50',
            'phone'                     =>  ['required','numeric', 'regex:/^((9665)|(05))[0-9]{8}$/'],
            'city'                      =>  'required|string|min:2',
            'qualification'             =>  'required|string|min:2',
            'specialization'            =>  'required|string|min:2',
            'do_you_work'               =>  'required|in:yes,no',
            'years_of_experience'       =>  'sometimes|nullable|integer',
            'current_place_of_work'     =>  'required|string|min:3|max:255',
            'about_your_experiences'    =>  'required|string|min:3',
            'cv'                        =>  'required|mimes:pdf|max:20000',
            'endorsement'               =>  'required|in:ok',
        ];
    }

    // public function attributes()
    // {
    //     return [
    //         'total_amount'      =>  trans('translation.amount'),
    //     ];
    // }
}
