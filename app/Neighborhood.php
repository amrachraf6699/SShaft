<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Neighborhood extends Model
{
    use SearchableTrait;

    protected $fillable =   [
        'name', 'city_id', 'status',
    ];

    protected $searchable = [
        'columns'   => [
            'neighborhoods.name'    => 10,
        ],
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
