<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class VideoSectionRequest extends FormRequest
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
                'title'     =>  'required|string|unique:video_sections,title',
                'status'    =>  'required|in:active,inactive',
                'img'       =>  'required|mimes:jpg,jpeg,png|max:20000',
            ];
        } else {
            return [
                'title'     =>  'required|string|unique:video_sections,title,'.$this->video_section,
                'status'    =>  'required|in:active,inactive',
                'img'       =>  'sometimes|mimes:jpg,jpeg,png|max:20000',
            ];
        }
    }

    public function attributes()
    {
        return [
            'title'     =>  trans('dashboard.title'),
            'status'    =>  trans('dashboard.status'),
            'img'       =>  trans('dashboard.img'),
        ];
    }
}
