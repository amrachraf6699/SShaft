<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
                'title'             =>  'required|string|unique:events,title',
                'content'           =>  'required|string|min:100',
                'location'          =>  'required|string',
                'date_of_event'     =>  'required',
                'time_of_event'     =>  'required',
                'status'            =>  'required|in:active,inactive',
                'img'               =>  'required|mimes:jpg,jpeg,png|max:20000',
            ];
        } else {
            return [
                'title'             =>  'required|string|unique:events,title,'.$this->event,
                'content'           =>  'required|string|min:100',
                'location'          =>  'required|string',
                'date_of_event'     =>  'required',
                'time_of_event'     =>  'required',
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
            'location'          =>  trans('translation.location'),
            'date_of_event'     =>  trans('translation.date_of_event'),
            'time_of_event'     =>  trans('translation.time_of_event'),
            'status'            =>  trans('dashboard.status'),
            'img'               =>  trans('dashboard.img'),
        ];
    }
}
