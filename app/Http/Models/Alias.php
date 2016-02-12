<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 12.02.2016
 * Time: 16:50
 */

namespace Anticafe\Http\Models;

use Anticafe\Http\Interfaces\ModelNameable;
use Illuminate\Database\Eloquent\Model;
use Stringy\StaticStringy;

class Alias extends Model implements ModelNameable
{

    private $name;

    protected $table = 'aliases';

    protected $guarded = [];

    public $incrementing = false;

    public $timestamps = false;

    public function setIdAttribute($value)
    {
        $this->attributes['id'] = StaticStringy::slugify($value);
    }

    public function Tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function setModelName()
    {
        return $this->name = "Синонимы";
    }

    public static function getModelName()
    {
        return (new static)->setModelName();
    }

    public function checkId()
    {
        $checked = static::find($this->id);
        if($checked != null && $checked->name == $this->name) {
            $this->id = $this->id."_".str_random(8);
        }

        return $this;
    }
}