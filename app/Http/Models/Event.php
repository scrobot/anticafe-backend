<?php

namespace Anticafe\Http\Models;

use Anticafe\Http\Interfaces\ModelNameable;
use Anticafe\Http\Services\ImageProcessor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

class Event extends Model implements ModelNameable
{

    protected $table = 'events';

    protected $guarded = ['_token','anticafes'];

    protected $dates = ['start_at', 'end_at'];

    private $name;

    private static $rules = [
        'title' => 'required',
        'start_at' => 'required',
        'end_at' => 'required',
    ];

    public $timestamps = false;

    public static function validator(Request $request)
    {
        return \Validator::make($request->all(), static::$rules);
    }

    public static function createOrUpdate(Request $request, $id = null)
    {
        $validator = static::validator($request);

        if($validator->fails())
            return $validator;

        $requestArray = $request->except('_token', 'anticafes');

        $entity = $id ? static::find($id) : static::create($requestArray);

        !$id ?: $entity->update($requestArray);

        $entity->syncWithAnticafes($request->input('anticafes'));
        $entity->attachImages($request->file('photo'), $request->file('cover'));

        return $entity;
    }

    public function setModelName()
    {
        return $this->name = "События";
    }

    public static function getModelName()
    {
        return (new static)->setModelName();
    }

    public function anticafes()
    {
        return $this->belongsToMany(Anticafe::class);
    }

    public function setExcerptAttribute($value)
    {
        $this->attributes['excerpt'] = nl2br($value);
    }

    public function getExcerptAttribute($value)
    {
        return html_entity_decode($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = nl2br($value);
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = nl2br($value);
    }

    public function getPriceAttribute($value)
    {
        return html_entity_decode($value);
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

    private function syncWithAnticafes($anticafes)
    {
        $anticafes = $anticafes == null ? [] : $anticafes;
        $this->anticafes()->sync($anticafes);
    }

    private function attachImages(File $photo = null, File $cover = null)
    {
        if($photo == null && $cover == null) {
            return false;
        }

        // TODO: Потом отрефакторить класс обработчика, чтобы все операцию производил одной инициализацией.
        $photo = $photo == null ? null : (new ImageProcessor($photo, 'events'))->start();
        $cover = $cover == null ? null : (new ImageProcessor($cover, 'events'))->start();

        if($photo != null) {
            $this->photo = $photo;
        }

        if($cover != null) {
            $this->cover = $cover;
        }

        $this->save();
    }
}