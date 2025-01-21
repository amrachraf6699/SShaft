<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;
use App\Http\Resources\SectionResource;
class ServiceSection extends Model
{
    use SearchableTrait, Sluggable; // SoftDeletes

    protected $fillable =   [
        'title', 'slug', 'status', 'parent_id', 'cover', 'image', 'desc'
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
            'service_sections.title'  => 10,
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
    
    public function getCoverPathAttribute()
    {
        return asset('storage/uploads/sections/' . $this->cover);
    }
    
    public function getImagePathAttribute()
    {
        return asset('storage/uploads/sections/' . $this->image);
    }

    public function scopeParent($query)
    {
        return $query->where('id', $this->parent_id)->first();
    }

    public function scopeChildren($query)
    {
        return $query->with('services')->where('parent_id', $this->id)->get();
    }

    public function scopeType($query)
    {
        if ($this->parent_id != null) {
            return 'sub_section';
        } else {
            return 'main_section';
        }
    }

    public function sections()
    {
        return $this->hasMany(ServiceSection::class, 'parent_id');
    }


    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }
}
