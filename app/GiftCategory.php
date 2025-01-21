<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class GiftCategory extends Model
{
    use SearchableTrait;

    protected $fillable =   [
        'title', 'status',
    ];

    protected $searchable = [
        'columns'   => [
            'gift_categories.title'  => 10,
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

    public function cards()
    {
        return $this->hasMany(GiftCard::class);
    }
}
