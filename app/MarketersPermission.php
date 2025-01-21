<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketersPermission extends Model
{
    protected $guarded = [];

    public function marketer()
    {
        return $this->belongsToMany(ServiceSection::class, 'id', 'marketer_id');
    }
}
