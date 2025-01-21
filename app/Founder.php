<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Founder extends Model
{
    use SearchableTrait;

    protected $fillable =   [
        'adjective', 'name', 'status', 'img', 'facebook_link',
        'twitter_link', 'instagram_link', 'linkedin_link',
    ];

    protected $searchable = [
        'columns'   => [
            'founders.adjective'    => 10,
            'founders.name'         => 10,
        ],
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('storage/uploads/founders/' . $this->img);
    }
}
