<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 07.07.2016
 * Time: 11:47
 */

namespace Anticafe\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Device extends Model
{

    protected $table = "devices";
    
    protected $guarded = [];

    public function Client()
    {
        return $this->belongsTo(Client::class);
    }
}