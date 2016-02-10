<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 10.02.2016
 * Time: 15:01
 */

namespace Anticafe\Http\Models;


use Anticafe\Http\Interfaces\ModelNameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class Anticafe extends Model implements ModelNameable
{

    use SoftDeletes;

    protected $table = "anticafes";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    private $name;

    private static $rules = [
        "name" => "required",
        "city" => "required",
        "metro" => "required",
        "prices" => "required",
        "routine" => "required",
        "phone" => "required",
    ];

    public static function validator(Request $request)
    {
        return \Validator::make($request->all(), static::$rules);
    }

    public static function customCreate(Request $request)
    {
        $validator = static::validator($request);

        if($validator->fails())
            return $validator;

        $entity = static::create($request->all());

        return $entity;
    }

    public function customUpdate(Request $request)
    {
        $validator = static::validator($request);

        if($validator->fails())
            return $validator;

        $this->update($request->except('logo', 'cover'));

        return true;
    }

    public function setModelName()
    {
        return $this->name = "Антикафе";
    }

    public static function getModelName()
    {
        return (new static)->setModelName();
    }
}