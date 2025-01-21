<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class GiftBankTransferRequest extends FormRequest
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
            'donor_id'          =>  'required|exists:donors,id|integer',
            'total_amount'      =>  'required|numeric',
            'sender_name'       =>  'required|string|min:3',
            'sender_phone'      =>  ['required','numeric', 'regex:/^((05))[0-9]{8}$/'],
            'recipient_name'    =>  'required|string|min:3',
            'recipient_phone'   =>  ['required','numeric', 'regex:/^((05))[0-9]{8}$/', 'different:sender_phone'],
            'recipient_email'   =>  'required|email|max:255',
            'gift_category_id'  =>  'required|exists:gift_categories,id|integer',
            'gift_card_id'      =>  'required|exists:gift_cards,id|integer',
            'payment_ways'      =>  'required|in:bank_transfer',
        ];
    }

    public function attributes()
    {
        return [
            'total_amount'      =>  trans('translation.amount'),
            'sender_name'       =>  trans('translation.sender_name'),
            'sender_phone'      =>  trans('translation.sender_phone'),
            'recipient_name'    =>  trans('translation.recipient_name'),
            'recipient_phone'   =>  trans('translation.recipient_phone'),
            'recipient_email'   =>  trans('translation.recipient_email'),
            'gift_category_id'  =>  trans('translation.gift_categories'),
            'gift_card_id'      =>  trans('translation.gift_cards'),
            'payment_ways'      => trans('translation.payment_ways'),
        ];
    }
}
