<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Module extends Model
{
    use SearchableTrait, Sluggable;

    protected $guarded = [];

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
            'modules.title'    => 10,
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

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        return asset('storage/uploads/modules/' . $this->file);
    }

    public function module_section()
    {
        return $this->belongsTo(ModuleSection::class);
    }
}
