<?php

namespace Anticafe\Http\Models;

use Anticafe\Http\Interfaces\ModelNameable;
use Anticafe\Http\Traits\UserValidatorTrait;
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
}
