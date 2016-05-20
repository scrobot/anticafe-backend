<?php

namespace Anticafe\Http\Models;

use Anticafe\Http\Interfaces\ModelNameable;
use Anticafe\Http\Traits\UserValidatorTrait;
use Helpers\Roles\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements ModelNameable
{

    use SoftDeletes, UserValidatorTrait;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['deleted_at'];

    private $name;

    public function setModelName()
    {
        return $this->name = "Пользователи";
    }

    public static function getModelName()
    {
        return (new static)->setModelName();
    }

    public function Bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function Roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function role()
    {
        return $this->Roles->first()->name;
    }

    public function Entities()
    {
        return $this->belongsToMany(Anticafe::class);
    }

    public function Anticafes()
    {
        return $this->Entities->where('type', 0);
    }

    public function Events()
    {
        return $this->Entities->where('type', 1);
    }

    public function hasRole($id)
    {
//        dd($this->Roles, $this->Roles->contains($id));
        return $this->Roles->contains($id);
    }

    public function isMe($user)
    {
        if($user == null)
            return false;

        $me = auth()->user();

        return $user->id == $me->id;
    }

    public function isMyAnticafe($anticafe_id)
    {
        $me = auth()->user();
        return $me->Entities->contains($anticafe_id);
    }

    public function sendEmailNotification(Booking $booking)
    {
        $that = $this;
        $book = [];
        $book['count_of_customers'] = $booking->count_of_customers;
        $book['comment'] = $booking->comment;
        $book['contacts'] = $booking->contacts;
        $book['arrival_at'] = $booking->arrival_at;
        $book['client_name'] = $booking->Client->first_name . " " . $booking->Client->last_name;
        $book['phone'] = $booking->Client->phone;
        $book['type'] = config("types.name.{$booking->Anticafe->type}");
        $book['ent'] = $booking->Anticafe->name;
        
        \Mail::send('emails.manager-notification', ['book' => $book], function($message) use ($that)
        {
            $message->from('booking@anticafe.im', "AntiCafe.im")->subject("AntiCafe.im Запрос на бронирование #{$that->id}");

            $message->to($that->email);
        });
    }
}
