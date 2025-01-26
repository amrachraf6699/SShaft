<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Service extends Model
{
    use SoftDeletes, SearchableTrait, Sluggable;

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
            'services.title'  => 10,
        ],
    ];

    protected $appends = ['image_path', 'percent', 'icon_app', 'cover_path'];

    public function getCoverPathAttribute()
    {
        return asset('storage/uploads/services/' . $this->cover);
    }

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/services/' . $this->img);
    }

    public function getIconAppAttribute()
    {
        return asset('storage/uploads/services/' . $this->app_icon);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeQuick_donation($query)
    {
        return $query->where('quick_donation', 'included');
    }

    // public function scopeCompleted($query)
    // {
    //     return $query->where('collected_value', '<', 'target_value');
    // }

    public function scopeMultiple_value($query)
    {
        return $query->where('price_value', 'multi');
    }

    public function service_section()
    {
        return $this->belongsTo(ServiceSection::class);
    }

    public function getPercentAttribute()
    {
        return $this->collected_value / $this->target_value * 100;
    }

    public function donations()
    {
        return $this->belongsToMany(Donation::class, 'donation_service')
                            ->withPivot(['quantity', 'amount']);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }
}
