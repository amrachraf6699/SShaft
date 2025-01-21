<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
                'title'             =>  'required|string|unique:videos,title',
                'video_section_id'  =>  'required|exists:video_sections,id|integer',
                'status'            =>  'required|in:active,inactive',
                'url'               =>  'required|url',
            ];
        } else {
            return [
                'title'             =>  'required|string|unique:videos,title,'.$this->video,
                'video_section_id'  =>  'required|exists:video_sections,id|integer',
                'status'            =>  'required|in:active,inactive',
                'url'               =>  'required|url',
            ];
        }
    }

    public function attributes()
    {
        return [
            'title'             =>  trans('dashboard.title'),
            'status'            =>  trans('dashboard.status'),
            'video_section_id'  =>  trans('translation.section'),
            'url'               =>  trans('dashboard.url'),
        ];
    }
}
