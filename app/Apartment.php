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
        return $this->belongsTo(User);
    }

    // Relationship with views
    public function views()
    {
        return $this->hasMany(View::class);
    }

    // Relationship with messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Relationship with services (pivot)
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    // Relationship with sponsors (pivot)
    public function sponsors()
    {
        return $this->belongsToMany(Apartment::class)
        // ->withPivot('date_start', 'date_end')
        ->withTimestamps();
    }

    protected $table = 'apartments';
}
