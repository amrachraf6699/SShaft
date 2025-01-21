<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationService extends Model
{
    protected $table    = 'donation_service';

    protected $fillable =   [
        'donation_id', 'service_id', 'quantity', 'amount',
    ];
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
