<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DirectorRequest extends FormRequest
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
                'adjective'         =>  'required|string|min:3',
                'name'              =>  'required|string|unique:directors,name',
                'job_title'         =>  'required|string|min:3',
                'facebook_link'     =>  'sometimes|nullable|url',
                'twitter_link'      =>  'sometimes|nullable|url',
                'instagram_link'    =>  'sometimes|nullable|url',
                'linkedin_link'     =>  'sometimes|nullable|url',
                'img'               =>  'required|mimes:jpg,jpeg,png|max:20000',
            ];
        } else {
            return [
                'adjective'         =>  'required|string|min:3',
                'name'              =>  'required|string|unique:directors,name,'.$this->director,
                'job_title'         =>  'required|string|min:3',
                'facebook_link'     =>  'sometimes|nullable|url',
                'twitter_link'      =>  'sometimes|nullable|url',
                'instagram_link'    =>  'sometimes|nullable|url',
                'linkedin_link'     =>  'sometimes|nullable|url',
                'img'               =>  'sometimes|required|mimes:jpg,jpeg,png|max:20000',
            ];
        }
    }

    public function attributes()
    {
        return [
            'adjective'         =>  trans('translation.adjective'),
            'name'              =>  trans('dashboard.name'),
            'job_title'         =>  trans('dashboard.job_title'),
            'facebook_link'     =>  trans('translation.facebook_link'),
            'twitter_link'      =>  trans('translation.twitter_link'),
            'instagram_link'    =>  trans('translation.instagram_link'),
            'linkedin_link'     =>  trans('translation.linkedin_link'),
            'img'               =>  trans('dashboard.img'),
        ];
    }
}
