<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 12.02.2016
 * Time: 16:50
 */

namespace Anticafe\Http\Models;


use Illuminate\Database\Eloquent\Model;
use Stringy\StaticStringy;

class Tag extends Model
{

    protected $table = 'tags';

    public $incrementing = false;

    public function setIdAttribute($value)
    {
        $this->attributes['id'] = StaticStringy::slugify($value);
    }

    public function Aliases()
    {
        return $this->belongsToMany(Alias::class);
    }

    public function Anticafes()
    {
        return $this->belongsToMany(Anticafe::class);
    }


}