<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Slider extends Model
{
    use SearchableTrait;

    protected $fillable = [
        'title', 'button', 'url', 'status', 'quick_donation', 'service_id', 'img', 'type'
    ];

    protected $searchable = [
        'columns'   => [
            'sliders.title'  => 10,
        ],
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/sliders/' . $this->img);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
