<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
    ];

    // Relationship with apartments (pivot)
    public function apartments()
    {
        return $this->belongsToMany('App\Apartment')
        ->withTimestamps();
    }

    protected $table = 'services';
}
