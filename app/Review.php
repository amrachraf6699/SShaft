<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'service_id', 'donor_id', 'rating',
         'review', 'status', 'donation_id',
    ];

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

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
