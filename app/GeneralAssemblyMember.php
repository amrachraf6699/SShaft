<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class GeneralAssemblyMember extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns'   => [
            'general_assembly_members.membership_no'    => 10,
            'general_assembly_members.first_name'       => 10,
            'general_assembly_members.last_name'        => 10,
            'general_assembly_members.email'            => 10,
            'general_assembly_members.phone'            => 10,
            'general_assembly_members.ident_num'        => 10,
        ],
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $membership_no   =   'GAM-' . date('dmy');

            while(GeneralAssemblyMember::whereMembershipNo($membership_no)->exists())
            {
                $membership_no = ++$membership_no;
            }
            $model->attributes['membership_no'] = $membership_no;
        });

        self::creating(function($model){
            $firstName  =   Str::slug($model->attributes['first_name']);
            $lastName   =   Str::slug($model->attributes['last_name']);
            $username   =   $firstName[0] . '.' . str_replace('-', '.', $lastName);

            $i = 0;
            while(GeneralAssemblyMember::whereUsername($username)->exists())
            {
                $i++;
                $username   =   $firstName[0] . '.' . str_replace('-', '.', $lastName) . '.' . $i;
            }
            $model->attributes['username'] = $username;
        });

        self::creating(function($model){
            $currentDate            = Carbon::now();
            // $subscriptionDate    = $currentDate->toDateString();
            $expiryDate             = date('Y-m-d', strtotime('12/31'));

            // $model->attributes['subscription_date'] = $subscriptionDate;
            $model->attributes['expiry_date']       = $expiryDate;
        });

        self::creating(function($model) {
            $uuid = Str::uuid()->toString();

            while(GeneralAssemblyMember::whereUuid($uuid)->exists())
            {
                $uuid = ++$uuid;
            }
            $model->attributes['uuid'] = $uuid;
        });
    }

    public function getFullNameAttribute()
    {
       return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/general_assembly_members/' . $this->attachments);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAwaitingPayment($query)
    {
        return $query->where('status', 'awaiting_payment');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeReceiveEmails($query)
    {
        return $query->where('receive_emails', 'yes');
    }

    public function scopeNotReceiveEmails($query)
    {
        return $query->where('receive_emails', 'no');
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function general_assembly_invoice()
    {
        return $this->belongsTo(GeneralAssemblyInvoice::class);
    }
}
