<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'apartment_id',
        'ip_user'
    ];

    // Relationship with apartments
    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }

    protected $table = 'views';
}
