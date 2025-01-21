<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class SeasonalProject extends Model
{
    use SearchableTrait, Sluggable;

    protected $fillable =   [
        'title', 'slug', 'content', 'img', 'status',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    protected $searchable = [
        'columns'   => [
            'seasonal_projects.title'  => 10,
        ],
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/seasonal_projects/' . $this->img);
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
