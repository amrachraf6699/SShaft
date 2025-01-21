<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable =   [
        'donor_id', 'service_id', 'quantity', 'amount',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}
