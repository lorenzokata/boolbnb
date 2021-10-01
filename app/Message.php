<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'apartment_id',
        'sender_email',
        'sender_fullname',
        'msg',
    ];

    // Relationship with apartments
    public function apartment()
    {
        return $this->belongsTo('App\Apartment');
    }

    protected $table = 'messages';
}
