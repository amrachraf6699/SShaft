<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class EmploymentApplication extends Model
{
    use SearchableTrait;

    protected $guarded = [];

    protected $searchable = [
        'columns'   => [
            'employment_applications.request_no'    => 10,
            'employment_applications.full_name'     => 10,
            'employment_applications.phone'         => 10,
            'employment_applications.email'         => 10,
            'employment_applications.city'          => 10,
        ],
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            $request_no   =   'BIR-EA-' . date('dmy');

            while(EmploymentApplication::whereRequestNo($request_no)->exists())
            {
                $request_no = ++$request_no;
            }
            $model->attributes['request_no'] = $request_no;
        });
    }

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        return asset('storage/uploads/employment_applications/' . $this->cv);
    }
}
