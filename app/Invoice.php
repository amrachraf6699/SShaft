<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Invoice extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns'   => [
            'invoices.invoice_no'    => 10,
        ],
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $invoice_no   =   'GAI-' . date('dmy');

            while(Invoice::whereInvoiceNo($invoice_no)->exists())
            {
                $invoice_no = ++$invoice_no;
            }
            $model->attributes['invoice_no'] = $invoice_no;
        });
    }

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/invoices/' . $this->attachments);
    }

    public function scopePaid($query)
    {
        return $query->where('invoice_status', 'unpaid');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('invoice_status', 'unpaid');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class);
    }
}
