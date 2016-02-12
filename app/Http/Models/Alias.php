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

class Alias extends Model
{

    protected $table = 'aliases';

    public $incrementing = false;

    public function setIdAttribute($value)
    {
        $this->attributes['id'] = StaticStringy::slugify($value);
    }

    public function Tags()
    {
        return $this->belongsToMany(Tag::class);
    }


}