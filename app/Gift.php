<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Gift extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns'   => [
            'gifts.gift_code'       => 10,
            'gifts.sender_name'     => 10,
            'gifts.sender_phone'    => 10,
            'gifts.recipient_name'  => 10,
            'gifts.recipient_phone' => 10,
        ],
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $gift_code   =   'BIR-G-' . date('dmy');

            while(Gift::whereGiftCode($gift_code)->exists())
            {
                $gift_code = ++$gift_code;
            }
            $model->attributes['gift_code'] = $gift_code;
        });
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function category()
    {
        return $this->belongsTo(GiftCategory::class);
    }

    public function card()
    {
        return $this->belongsTo(GiftCard::class);
    }

    // gift card path
    protected $appends = ['gift_card_path'];

    public function getGiftCardPathAttribute()
    {
        return asset('storage/uploads/gift_cards_to_donors/' . $this->gift_card_name);
    }
}
