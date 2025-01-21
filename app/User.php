<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'user_group_id', 'gender', 'phone',
        'user_status', 'ident_num', 'age',
        'qualification', 'nationality', 'address',
        'branch_id'
    ];

    protected $searchable = [
        'columns'   => [
            'users.name'    => 10,
            'users.email'   => 10,
            'users.phone'   => 10,
        ],
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('user_status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('user_status', 'inactive');
    }

    public function user_group()
    {
        return $this->belongsTo(UserGroup::class);
    }
}
