<?php

namespace Anticafe\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';

    protected $guarded = [];

    public function Likes()
    {
        return $this->belongsToMany(Anticafe::class, 'likes', 'anticafe_id', 'client_id');
    }

    public function Bookings()
    {
        return $this->hasMany(Booking::class);
    }

}