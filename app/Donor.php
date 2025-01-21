<?php

namespace App;

use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Donor extends Authenticatable
{
    use HasApiTokens, SearchableTrait, Notifiable;

    protected $guarded = [];

    protected $searchable = [
        'columns'   => [
            'donors.membership_no'    => 10,
            'donors.name'             => 10,
            'donors.email'            => 10,
            'donors.phone'            => 10,
        ],
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $membership_no   =   'D-' . date('dmy');

            while(Donor::whereMembershipNo($membership_no)->exists())
            {
                $membership_no = ++$membership_no;
            }
            $model->attributes['membership_no'] = $membership_no;
        });

        self::creating(function($model) {
            if (strlen($model->attributes['phone']) === 12)
                $username   =   substr($model->attributes['phone'], 4) . $model->attributes['membership_no'];
            else
                $username   =   substr($model->attributes['phone'], 2) . $model->attributes['membership_no'];
            $model->attributes['username'] = $username;
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeReceiveEmails($query)
    {
        return $query->where('receive_emails', 'yes');
    }

    public function scopeNotReceiveEmails($query)
    {
        return $query->where('receive_emails', 'no');
    }

    public function invoices()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function carts()
    {
        return $this->belongsToMany(Service::class, 'carts')
                    ->withPivot(['amount', 'quantity', 'id'])
                    ->withTimestamps();
    }

    public function cartsWithServiceValue() {
        return $this->hasMany(Cart::class)
                    ->join('services', 'carts.service_id', 'services.id')
                    ->select('carts.*',
                             DB::raw('carts.quantity * carts.amount as subtotal')
                            );
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
