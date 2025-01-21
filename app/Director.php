<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Director extends Model
{
    use SearchableTrait;

    protected $fillable =   [
        'adjective', 'name', 'job_title', 'img', 'facebook_link',
        'twitter_link', 'instagram_link', 'linkedin_link',
    ];

    protected $searchable = [
        'columns'   => [
            'directors.adjective'        => 10,
            'directors.name'         => 10,
            'directors.job_title'    => 10,
        ],
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/directors/' . $this->img);
    }
}
