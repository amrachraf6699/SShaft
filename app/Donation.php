<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Donation extends Model
{
    use SearchableTrait;

    protected $fillable = [
        'donor_id', 'donation_code', 'total_amount', 'status',
        'donation_type', 'bank_transaction_id', 'payment_brand',
        'payment_ways', 'bank_name', 'attachments', 'gift_id',
        'marketer_id', 'beneficiary_id',
        'branch_id', 'response'
        // 'id', 'created_at', 'updated_at'
    ];

    protected $searchable = [
        'columns'   => [
            'donations.donation_code'   => 10,
            'donations.bank_name'       => 10,
        ],
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $donation_code   =   'TKF-' . date('dmy');

            while(Donation::whereDonationCode($donation_code)->exists())
            {
                $donation_code = ++$donation_code;
            }
            $model->attributes['donation_code'] = $donation_code;
        });
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'donation_service')
                    ->withPivot(['quantity', 'amount']);
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }
    
    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

    protected $appends = ['transfer_receipt'];

    public function getTransferReceiptAttribute()
    {
        return asset('storage/uploads/transfer_receipts/' . $this->attachments);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    public function scopeDonations($query)
    {
        return $query->where('donation_type', 'donation');
    }

    public function scopeGifts($query)
    {
        return $query->where('donation_type', 'gift');
    }

    public function scopeQuicks($query)
    {
        return $query->where('donation_type', 'quick_donation');
    }

    public function scopeMarketer($query)
    {
        return $query->where('donation_type', 'marketer');
    }

    public function scopeVerification($query)
    {
        return $query->where('status', 'unpaid')
                        ->where('bank_name', '!=', null)
                        ->where('attachments', '!=', null);
    }
}
