<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Photo extends Model
{
    use SearchableTrait;

    protected $fillable =   [
        'photo_section_id', 'title', 'views_count', 'img', 'status',
    ];


    protected $searchable = [
        'columns'   => [
            'photos.title'  => 10,
        ],
    ];

    protected $appends = ['image_path', 'link'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/photos/' . $this->img);
    }

    public function getLinkAttribute()
    {
        return route('frontend.photos.index', $this->photo_section->slug);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function photo_section()
    {
        return $this->belongsTo(PhotoSection::class);
    }
}
