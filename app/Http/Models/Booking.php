<?php

namespace Anticafe\Http\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    protected $table = 'bookings';

    protected $guarded = [];

    protected $dates = ['arrival_at'];

    public function getRawArrivalDate()
    {
        return Carbon::createFromFormat('d.m в H:i', $this->arrival_at);
    }

    public function getArrivalTimestamp() {
        return $this->getRawArrivalDate()->timestamp;
    }

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }

    public function Manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Anticafe()
    {
        return $this->belongsTo(Anticafe::class);
    }

    public function getArrivalAtAttribute($value)
    {
        if($value == null) {
            return $value;
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m в H:i');
    }

    public function setArrivalAtAttribute($value)
    {
        $carbon = Carbon::parse($value);
        $this->attributes['arrival_at'] = $carbon->format('Y-m-d H:i:s');/*Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d F Y в H:i');;*/
    }

}