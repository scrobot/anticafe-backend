<?php

namespace Anticafe\Http\Models;

use Anticafe\Http\Traits\ListTrait;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $table = 'clients';

    protected $guarded = [];

    public static $rules = [
        "create" => [
            "email" => "required|email|unique:clients",
            "password" => "required"
        ],
        "auth" => [
            "email" => "required|email",
            "password" => "required"
        ]
    ];
    
    use ListTrait;

    public function Likes()
    {
        return $this->belongsToMany(Anticafe::class, 'likes', 'client_id', 'anticafe_id');
    }

    public function Bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function sendEmailNotification(Booking $booking, $status)
    {
        $that = $this;
        $book = [];
        $book['id'] = $booking->id;
        $book['count_of_customers'] = $booking->count_of_customers;
        $book['comment'] = $booking->comment;
        $book['contacts'] = $booking->contacts;
        $book['arrival_at'] = $booking->arrival_at;
        $book['status'] = $status;
        \Mail::send('emails.client-notification', ['book' => $book], function($message) use ($that)
        {
            $message->from('booking@anticafe.im', 'Anticafe.im')->subject("Уведомления о изменении статуса заказа");

            $message->to($that->email);
        });
    }

}