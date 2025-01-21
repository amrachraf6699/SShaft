<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Event extends Model
{
    use SearchableTrait, Sluggable;

    protected $fillable =   [
        'title', 'slug', 'content', 'date_of_event', 'time_of_event',
        'views_count', 'img', 'status', 'location',
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
            'events.title'  => 10,
        ],
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/events/' . $this->img);
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
