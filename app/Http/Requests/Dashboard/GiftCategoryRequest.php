<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class GiftCategoryRequest extends FormRequest
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
                'title'     =>  'required|string|unique:gift_categories,title',
                'status'    =>  'required|in:active,inactive',
                'cards.*'   =>  'required|mimes:jpg,jpeg,png,gif|max:20000',
            ];
        } else {
            return [
                'title'     =>  'required|string|unique:gift_categories,title,'.$this->gift_category,
                'status'    =>  'required|in:active,inactive',
                'cards.*'   =>  'sometimes|required|mimes:jpg,jpeg,png,gif|max:20000',
            ];
        }
    }

    public function attributes()
    {
        return [
            'title'     =>  trans('dashboard.title'),
            'status'    =>  trans('dashboard.status'),
            'cards'     =>  trans('translation.gift_cards'),
        ];
    }
}
