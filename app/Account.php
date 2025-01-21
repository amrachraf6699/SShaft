<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Account extends Model
{
    use SearchableTrait;

    protected $fillable =   [
        'bank_name', 'account_number', 'IBAN', 'bank_link', 'status',
    ];

    protected $searchable = [
        'columns'   => [
            'accounts.bank_name'        => 10,
            'accounts.account_number'   => 10,
            'accounts.IBAN'             => 10,
        ],
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
