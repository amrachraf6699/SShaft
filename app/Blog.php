<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Blog extends Model
{
    use SearchableTrait, Sluggable;

    protected $fillable =   [
        'blog_section_id', 'title', 'slug', 'content',
        'views_count', 'img', 'status',
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
            'blogs.title'  => 10,
        ],
    ];

    protected $appends = ['image_path', 'link'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/blogs/' . $this->img);
    }

    public function getLinkAttribute()
    {
        return route('frontend.news-details.show', [$this->blog_section->slug, $this->slug]);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function blog_section()
    {
        return $this->belongsTo(BlogSection::class);
    }
}
