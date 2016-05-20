<?php
namespace Anticafe\Http\Models;


use Anticafe\Http\Interfaces\ModelNameable;
use Anticafe\Http\Services\ImageProcessor;
use Carbon\Carbon;
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
        "pincode" => "required|numeric|unique:anticafes|min:4",
        "name" => "required",
        "prices" => "required",
    ];

    /**
     * GETing methods
     * @return mixed
     */

    // TODO: заменить на skope

    public static function getAnticafes()
    {
        return static::where('type', 0);
    }

    public static function getEvents()
    {
        return static::where('type', 1);
    }

    /**
     * ------------------------- *
    */

    /**
     * Relation methods
     */

    public function Tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeFindByPincode($query, $pincode)
    {
        return $query->where("pincode", $pincode);
    }

    public function Events()
    {
        return $this->belongsToMany(static::class, 'anticafe_event', 'anticafe_id', 'event_id');
    }

    public function Anticafes()
    {
        return $this->belongsToMany(static::class, 'anticafe_event', 'event_id', 'anticafe_id');
    }

    public function Liked()
    {
        return $this->belongsToMany(Client::class, 'likes', 'client_id', 'anticafe_id');
    }

    public function Bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function Users()
    {
        return $this->belongsToMany(User::class);
    }

    public function Manager()
    {
        return $this->Users->first();
    }

    /**
     * ------------------------- *
     */

    public static function validator(Request $request)
    {
        return \Validator::make($request->all(), static::$rules);
    }

    public static function customCreate(Request $request, $isEvent = false)
    {
        $validator = static::validator($request);

        if($validator->fails())
            return $validator;

        $entity = static::create($request->except('logo', 'cover', 'tags', 'anticafes'));

        $entity->attachImages($request->file('logo'), $request->file('cover'));

        if($isEvent) {
            $entity->attachAnticafes($request->input('anticafes'));
            $entity->setBookingAvailable($request->input('booking_available'));
        }

        $entity->attachTags($request->input('tags'));

        $entity->setPromo($request->input('promo'));

        ImageRepository::saveFromSession($entity, $request->input('_session'));

        return $entity;
    }

    public function customUpdate(Request $request, $isEvent = false)
    {
        $validator = static::validator($request);

        if($validator->fails())
            return $validator;

        $this->update($request->except('logo', 'cover', 'tags', 'anticafes'));

        $this->attachImages($request->file('logo'), $request->file('cover'));

        if($isEvent) {
            $this->attachAnticafes($request->input('anticafes'));
            $this->setBookingAvailable($request->input('booking_available'));
        }

        $this->attachTags($request->input('tags'));

        $this->setPromo($request->input('promo'));

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

    public function setStartAtAttribute($value)
    {
        if($value != null)
            $this->attributes['start_at'] = Carbon::createFromFormat('d.m.Y H:i', $value)->toDateTimeString();
    }

    public function setEndAtAttribute($value)
    {
        if($value != null)
            $this->attributes['end_at'] = Carbon::createFromFormat('d.m.Y H:i', $value)->toDateTimeString();
    }

    public function getEndAtAttribute($value)
    {
        if($value == null) {
            return $value;
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.Y H:i');
    }

    public function getStartAtAttribute($value)
    {
        if($value == null) {
            return $value;
        }

        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.Y H:i');
    }

    public static function anticafesCount() {
        return static::where('type', 0)->count();
    }

    public static function eventsCount() {
        return static::where('type', 1)->count();
    }

    private function attachTags($tags)
    {
        $tags = $tags == null ? [] : $tags;
        $this->Tags()->sync($tags);
    }

    private function attachAnticafes($anticafes)
    {
        $anticafes = $anticafes == null ? [] : $anticafes;
        $this->Anticafes()->sync($anticafes);
    }

    private function setPromo($is_promo)
    {
        $this->promo = $is_promo ? 1 : 0;
        $this->save();
    }

    private function setBookingAvailable($booking_available) {
        $this->booking_available = $booking_available ? 1 : 0;
        $this->save();
    }

    public function setTags() {
        $tags = [];
        $counter = 0;
        foreach($this->Tags as $tag) {
            $tags[$counter] = [
                "id" => $tag->id,
                "slug" => $tag->slug,
                "name" => $tag->name,
                "parent_id" => $tag->parent_id,
                "is_group" => $tag->is_group,
                "icon" => $tag->icon,
            ];
            if($tag->parent_id != null) {
                $tags[$counter]["group"] = [
                    "id" => $tag->Group->id,
                    "slug" => $tag->Group->slug,
                    "name" => $tag->Group->name,
                    "parent_id" => $tag->Group->parent_id,
                    "is_group" => $tag->Group->is_group,
                    "icon" => $tag->Group->icon,
                ];
            }
            $counter++;
        }
    }
}