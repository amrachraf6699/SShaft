<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Government extends Model
{
    use SearchableTrait, Sluggable;

    protected $fillable =   [
        'title', 'slug', 'content', 'file', 'status',
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
            'governments.title'  => 10,
        ],
    ];

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        return asset('storage/uploads/governments/' . $this->file);
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
