<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Contact extends Model
{
    use SearchableTrait;

    protected $fillable = [
        'name', 'phone', 'email', 'subject', 'message', 'status',
    ];

    protected $searchable = [
        'columns'   => [
            'contacts.name'     => 10,
            'contacts.email'    => 10,
            'contacts.phone'    => 10,
            'contacts.subject'  => 10,
        ],
    ];
}
