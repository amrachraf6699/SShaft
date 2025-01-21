<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Beneficiary extends Model
{
    use SearchableTrait, Sluggable;

    protected $guarded = [];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ]
        ];
    }

    protected $searchable = [
        'columns'   => [
            'beneficiaries.membership_no'    => 10,
            'beneficiaries.name'             => 10,
            'beneficiaries.email'            => 10,
            'beneficiaries.phone'            => 10,
            'beneficiaries.ident_num'        => 10,
            'beneficiaries.neighborhood'     => 10,
        ],
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $membership_no   =   'B-' . date('dmy');

            while(Beneficiary::whereMembershipNo($membership_no)->exists())
            {
                $membership_no = ++$membership_no;
            }
            $model->attributes['membership_no'] = $membership_no;
        });

        self::creating(function($model) {
            $name       =   Str::slug($model->attributes['name']);
            $username   =   str_replace('-', '.', $name);

            $i = 0;
            while(Beneficiary::whereUsername($username)->exists())
            {
                $i++;
                $username = str_replace('-', '.', $name) . '.' . $i;
            }
            $model->attributes['username'] = $username;
        });
    }

    protected $appends = ['ident_image_path', 'image_path', 'icon_app'];

    public function getIdentImagePathAttribute()
    {
        return asset('storage/uploads/beneficiaries_requests/' . $this->ident_img);
    }

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/beneficiaries_requests/' . $this->img);
    }

    public function getIconAppAttribute()
    {
        return asset('storage/uploads/beneficiaries_requests/' . $this->app_icon);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeShow($query)
    {
        return $query->where('publish_status', 'show');
    }

    public function scopeHide($query)
    {
        return $query->where('publish_status', 'hide');
    }

    public function scopeQuick_donation($query)
    {
        return $query->where('quick_donation', 'included');
    }

    public function scopeMultiple_value($query)
    {
        return $query->where('price_value', 'multi');
    }

    public function getPercentAttribute()
    {
        return $this->collected_value / $this->target_value * 100;
    }

    public function families()
    {
        return $this->belongsToMany(Beneficiary::class, 'beneficiary_families');
    }

    public function service_section()
    {
        return $this->belongsTo(ServiceSection::class);
    }
}
