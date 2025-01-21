<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $merchant_transaction_id    =    'pay_' . bin2hex(openssl_random_pseudo_bytes(8)) . date('Ymdhmi');

            while(Order::whereMerchantTransactionId($merchant_transaction_id)->exists())
            {
                $merchant_transaction_id = ++$merchant_transaction_id;
            }
            $model->attributes['merchant_transaction_id'] = $merchant_transaction_id;
        });
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'order_service')
                    ->withPivot(['quantity', 'amount']);
    }

    public function details()
    {
        return $this->hasMany(OrderService::class, 'order_id', 'id');
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}
