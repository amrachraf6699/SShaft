<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Survey extends Model
{
    use SearchableTrait;

    protected $fillable = [
        'title', 'status', 'very_satisfied', 'somewhat_satisfied',
        'neutral', 'not_satisfied', 'angry'
    ];

    protected $searchable = [
        'columns'   => [
            'surveys.title'  => 10,
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

    // protected $appends = ['total_votes' , 'percent_very_satisfied', 'percent_somewhat_satisfied', 'percent_neutral'];

    public function getTotalVotesAttribute()
    {
        return $this->very_satisfied + $this->somewhat_satisfied + $this->neutral + $this->not_satisfied + $this->angry;
    }

    public function getPercentVerySatisfiedAttribute()
    {
        $total_votes = $this->very_satisfied + $this->somewhat_satisfied + $this->neutral + $this->not_satisfied + $this->angry;
        if ($total_votes != 0) {
            return  $this->very_satisfied / $total_votes * 100;
        }
        return  0;
    }

    public function getPercentSomewhatSatisfiedAttribute()
    {
        $total_votes = $this->very_satisfied + $this->somewhat_satisfied + $this->neutral + $this->not_satisfied + $this->angry;
        if ($total_votes != 0) {
            return $this->somewhat_satisfied / $total_votes * 100;
        }
        return  0;
    }

    public function getPercentNeutralAttribute()
    {
        $total_votes = $this->very_satisfied + $this->somewhat_satisfied + $this->neutral + $this->not_satisfied + $this->angry;
        if ($total_votes != 0) {
            return $this->neutral / $total_votes * 100;
        }
        return  0;
    }

    public function getPercentNotSatisfiedAttribute()
    {
        $total_votes = $this->very_satisfied + $this->somewhat_satisfied + $this->neutral + $this->not_satisfied + $this->angry;
        if ($total_votes != 0) {
            return $this->not_satisfied / $total_votes * 100;
        }
        return  0;
    }

    public function getPercentAngryAttribute()
    {
        $total_votes = $this->very_satisfied + $this->somewhat_satisfied + $this->neutral + $this->not_satisfied + $this->angry;
        if ($total_votes != 0) {
            return $this->angry / $total_votes * 100;
        }
        return  0;
    }
}
