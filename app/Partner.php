<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Partner extends Model
{
    use SearchableTrait;

    protected $fillable = [
        'name', 'status', 'img', 'content', 'url',
    ];

    protected $searchable = [
        'columns'   => [
            'partners.name'    => 10,
        ],
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/partners/' . $this->img);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
