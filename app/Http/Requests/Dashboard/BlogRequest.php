<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
                'title'             =>  'required|string|unique:blogs,title',
                'content'           =>  'required|string|min:100',
                'blog_section_id'   =>  'required|exists:blog_sections,id|integer',
                'status'            =>  'required|in:active,inactive',
                'img'               =>  'required|mimes:jpg,jpeg,png|max:20000',
            ];
        } else {
            return [
                'title'             =>  'required|string|unique:blogs,title,'.$this->blog,
                'content'           =>  'required|string|min:100',
                'blog_section_id'   =>  'required|exists:blog_sections,id|integer',
                'status'            =>  'required|in:active,inactive',
                'img'               =>  'sometimes|mimes:jpg,jpeg,png|max:20000',
            ];
        }
    }

    public function attributes()
    {
        return [
            'title'             =>  trans('dashboard.title'),
            'content'           =>  trans('dashboard.content'),
            'status'            =>  trans('dashboard.status'),
            'blog_section_id'   =>  trans('translation.section'),
            'img'               =>  trans('dashboard.img'),
        ];
    }
}
