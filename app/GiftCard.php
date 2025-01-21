<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(GiftCategory::class);
    }

    protected $appends = ['card_path'];

    public function getCardPathAttribute()
    {
        return asset('storage/uploads/gift_cards/' . $this->file_name);
    }
}
