<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LiftCenter extends Model
{
    protected $fillable = ['id', 'file'];

    protected $casts = [
        'id' => 'string'
    ];

    protected $appends = ['file_path'];

    public function getFilePathAttribute()
    {
        return asset('storage/uploads/lift_centers/' . $this->file);
    }
}
