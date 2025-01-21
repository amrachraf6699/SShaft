<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable =   [
        'key', 'how_to_join', 'joining_terms', 'membership_benefits', 'img'
    ];

    public $timestamps = false;

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/pages/' . $this->img);
    }
}
