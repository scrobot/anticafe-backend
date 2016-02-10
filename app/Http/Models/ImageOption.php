<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 10.02.2016
 * Time: 17:44
 */

namespace Anticafe\Http\Models;


use Anticafe\Http\Interfaces\ModelNameable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ImageOption extends Model implements ModelNameable
{

    protected $table = "image_options";

    protected $guarded = [];

    private $name;

    public $timestamps = false;

    private static $rules = [
        "name" => "required",
        "width" => "required|numeric",
        "height" => "required|numeric",
        "anchor" => "required",
    ];

    public static function validator(Request $request)
    {
        return \Validator::make($request->all(), static::$rules);
    }

    public function setModelName()
    {
        return $this->name = "Опции изображений";
    }

    public static function getModelName()
    {
        return (new static)->setModelName();
    }

    // TODO: отрефакторить в trait

    public static function customCreate($request)
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

        $this->update($request->all());

        return true;
    }

}