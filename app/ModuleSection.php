<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class ModuleSection extends Model
{
    use SearchableTrait,  Sluggable;

    protected $fillable =   [
        'title', 'slug', 'views_count', 'img', 'status', 'id'
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
            'module_sections.title'  => 10,
        ],
    ];

    // protected $appends = ['image_path'];

    // public function getImagePathAttribute()
    // {
    //     return asset('storage/uploads/modules/' . $this->img);
    // }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
