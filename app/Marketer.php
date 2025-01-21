<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Marketer extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns'   => [
            'marketers.marketer_id' => 10,
            'marketers.first_name'  => 10,
            'marketers.last_name'   => 10,
        ],
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $marketer_id   =   'MA' . date('dmy');

            while(Marketer::whereMarketerId($marketer_id)->exists())
            {
                $marketer_id = ++$marketer_id;
            }
            $model->attributes['marketer_id'] = $marketer_id;
        });

        self::creating(function($model){
            $firstName  =   Str::slug($model->attributes['first_name']);
            $lastName   =   Str::slug($model->attributes['last_name']);
            $username   =   $firstName[0] . '.' . str_replace('-', '.', $lastName);

            $i = 0;
            while(Marketer::whereUsername($username)->exists())
            {
                $i++;
                $username   =   $firstName[0] . '.' . str_replace('-', '.', $lastName) . '.' . $i;
            }
            $model->attributes['username'] = $username;
        });
    }

    public function getFullNameAttribute()
    {
       return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function marketerPermissions()
    {
        return $this->belongsToMany(ServiceSection::class, 'marketers_permissions')
                ->select(['id', 'service_section_id']);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class)->select('donations.*',
            DB::raw('SUM(total_amount) AS total_donations')
        );
    }
}
