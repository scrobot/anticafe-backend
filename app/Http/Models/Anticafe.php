<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 10.02.2016
 * Time: 15:01
 */

namespace Anticafe\Http\Models;


use Anticafe\Http\Interfaces\ModelNameable;
use Anticafe\Http\Services\ImageProcessor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

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
        $this->images($request->file('logo'), $request->file('cover'));

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

    private function images(File $logo = null, File $cover = null)
    {
        if($logo == null && $cover == null) {
            return false;
        }

        // TODO: Потом отрефакторить класс обработчика, чтобы все операцию производил одной инициализацией.
        $logo = $logo == null ?: (new ImageProcessor($logo, 'logos'))->start();
        $cover = $cover == null ?: (new ImageProcessor($cover, 'covers'))->start();

        if($logo != null) {
            $this->logo = $logo;
        }

        if($cover != null) {
            $this->cover = $cover;
        }

        $this->save();
    }
}