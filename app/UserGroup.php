<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserGroup extends Model
{
    use SearchableTrait;

    protected $fillable =   ['title'];

    protected $searchable = [
        'columns'   => [
            'user_groups.title'  => 10,
        ],
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
