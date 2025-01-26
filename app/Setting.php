<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function getLogoPathAttribute()
    {
        return asset('storage/uploads/settings/' . $this->logo);
    }

    public function getFavPathAttribute()
    {
        return asset('storage/uploads/settings/' . $this->fav);
    }
}
