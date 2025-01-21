<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Video extends Model
{
    use SearchableTrait, Sluggable;

    protected $fillable =   [
        'video_section_id', 'title', 'slug', 'url',
        'views_count', 'status',
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
            'videos.title'  => 10,
        ],
    ];

    protected $appends = ['image_path', 'link'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/videos/' . $this->img);
    }

    public function getLinkAttribute()
    {
        return route('frontend.videos-details.show', [$this->video_section->slug, $this->slug]);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function video_section()
    {
        return $this->belongsTo(VideoSection::class);
    }
}
