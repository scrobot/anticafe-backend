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

    public $timestamps = false;

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = StaticStringy::slugify($value);
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
}