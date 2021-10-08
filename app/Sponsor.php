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
        return $this->belongsToMany('App\Service')
        // ->withPivot('date_start', 'date_end')
        ->withTimestamps();
    }

    protected $table = 'sponsors';
}
