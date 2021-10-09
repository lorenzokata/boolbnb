<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'n_rooms',
        'n_beds',
        'n_baths',
        'square_meters',
        'lat',
        'lon',
        'city',
        'zip_code',
        'street',
        'address',
        'imgs',
        'visible',
        'slug'
    ];

    // Relationship with users
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Relationship with views
    public function views()
    {
        return $this->hasMany('App\View');
    }

    // Relationship with messages
    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    // Relationship with services (pivot)
    public function services()
    {
        return $this->belongsToMany('App\Service');
    }

    // Relationship with sponsors (pivot)
    public function sponsors()
    {
        return $this->belongsToMany('App\Sponsor', 'apartment_sponsor')
        ->withTimestamps()
        ->withPivot(['date_start', 'date_end']);
        
        
    }

    protected $table = 'apartments';
}
