<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'time_span',
        'price',
        'name'
    ];

    // Relationship with apartments (pivot)
    public function services()
    {
        return $this->belongsToMany('App\Service')
        ->withPivot('date_start', 'date_stop')
        ->withTimestamps();
    }

    protected $table = 'sponsors';
}
