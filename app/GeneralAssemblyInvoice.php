<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class GeneralAssemblyInvoice extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns'   => [
            'general_assembly_invoices.invoice_no'    => 10,
        ],
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $invoice_no   =   'GAI-' . date('dmy');

            while(GeneralAssemblyInvoice::whereInvoiceNo($invoice_no)->exists())
            {
                $invoice_no = ++$invoice_no;
            }
            $model->attributes['invoice_no'] = $invoice_no;
        });
    }

    protected $appends = ['transfer_receipt'];

    public function getTransferReceiptAttribute()
    {
        return asset('storage/uploads/transfer_receipts/' . $this->attachments);
    }

    public function scopePaid($query)
    {
        return $query->where('invoice_status', 'unpaid');
    }

    public function scopeUnpaid($query)
    {
        return $query->where('invoice_status', 'unpaid');
    }

    public function scopeAwaitingVerification($query)
    {
        return $query->where('invoice_status', 'awaiting_verification');
    }

    public function general_assembly_member()
    {
        return $this->belongsTo(GeneralAssemblyMember::class);
    }
}
