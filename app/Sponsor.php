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
    public function apartments()
    {
        return $this->belongsToMany('App\Apartment')
        ->withTimestamps();
    }

    protected $table = 'sponsors';
}
