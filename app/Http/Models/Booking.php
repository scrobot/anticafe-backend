<?php

namespace Anticafe\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $table = 'bookings';

    protected $guarded = [];

    protected $dates = ['arrival_at'];

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }

    public function Manager()
    {
        return $this->belongsTo(User::class);
    }

    public function Anticafe()
    {
        return $this->belongsTo(Anticafe::class);
    }
}