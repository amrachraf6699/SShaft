<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class FounderRequest extends FormRequest
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
                'name'              =>  'required|string|unique:founders,name',
                'facebook_link'     =>  'sometimes|nullable|url',
                'twitter_link'      =>  'sometimes|nullable|url',
                'instagram_link'    =>  'sometimes|nullable|url',
                'linkedin_link'     =>  'sometimes|nullable|url',
                'status'            =>  'required|in:alive,deceased',
                'img'               =>  'required|mimes:jpg,jpeg,png|max:20000',
            ];
        } else {
            return [
                'adjective'         =>  'required|string|min:3',
                'name'              =>  'required|string|unique:founders,name,'.$this->founder,
                'facebook_link'     =>  'sometimes|nullable|url',
                'twitter_link'      =>  'sometimes|nullable|url',
                'instagram_link'    =>  'sometimes|nullable|url',
                'linkedin_link'     =>  'sometimes|nullable|url',
                'status'            =>  'required|in:alive,deceased',
                'img'               =>  'sometimes|required|mimes:jpg,jpeg,png|max:20000',
            ];
        }
    }

    public function attributes()
    {
        return [
            'adjective'         =>  trans('translation.adjective'),
            'name'              =>  trans('dashboard.name'),
            'facebook_link'     =>  trans('translation.facebook_link'),
            'twitter_link'      =>  trans('translation.twitter_link'),
            'instagram_link'    =>  trans('translation.instagram_link'),
            'linkedin_link'     =>  trans('translation.linkedin_link'),
            'status'            =>  trans('dashboard.status'),
            'img'               =>  trans('dashboard.img'),
        ];
    }
}
