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
use Helpers\ImageHandler\ImageableTrait;
use Helpers\ImageHandler\ImageRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

class Anticafe extends Model implements ModelNameable
{
    use SoftDeletes, ImageableTrait;

    protected $table = "anticafes";

    protected $guarded = [];

    protected $dates = ['deleted_at', 'start_at', 'end_at'];

    private $name;

    private static $rules = [
        "name" => "required",
        "city" => "required",
        "metro" => "required",
        "prices" => "required",
        "routine" => "required",
        "phone" => "required",
    ];

    public function Tags()
    {
        return $this->belongsToMany(Tag::class);
    }

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

    public function customUpdate(Request $request, $step = null)
    {
        if($step == null) {
            $validator = static::validator($request);
            if($validator->fails())
                return $validator;

            $this->update($request->except('logo', 'cover', 'tags'));
        }

        $this->attachImages($request->file('logo'), $request->file('cover'));
        $this->attachTags($request->input('tags'));

        if($request->input('_session') != null)
            ImageRepository::saveFromSession($this, $request->input('_session'));

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

    private function attachImages(File $logo = null, File $cover = null)
    {
        if($logo == null && $cover == null) {
            return false;
        }

        // TODO: Потом отрефакторить класс обработчика, чтобы все операцию производил одной инициализацией.
        $logo = $logo == null ? null : (new ImageProcessor($logo, 'logos'))->start();
        $cover = $cover == null ? null : (new ImageProcessor($cover, 'covers'))->start();

        if($logo != null) {
            $this->logo = $logo;
        }

        if($cover != null) {
            $this->cover = $cover;
        }

        $this->save();
    }

    public function setPricesAttribute($value)
    {
        $this->attributes['prices'] = nl2br($value);
    }

    public function setMetroAttribute($value)
    {
        $this->attributes['metro'] = nl2br($value);
    }

    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = Carbon::createFromFormat('d.m.Y H:i', $value)->toDateTimeString();
    }

    public function setEndAtAttribute($value)
    {
        $this->attributes['end_at'] = Carbon::createFromFormat('d.m.Y H:i', $value)->toDateTimeString();
    }

    public function getEndAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.Y H:i');
    }

    public function getStartAtAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.Y H:i');
    }

    private function attachTags($tags)
    {
        $tags = $tags == null ? [] : $tags;
        $this->Tags()->sync($tags);
    }
}