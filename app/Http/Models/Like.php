<?php
/**
 * Created by PhpStorm.
 * User: aleksejskrobot
 * Date: 04.07.16
 * Time: 14:42
 */

namespace Anticafe\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Like extends Model
{

    protected $table = "likes";

    public function Anticafe()
    {
        return $this->belongsTo(Anticafe::class);
    }

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }

}