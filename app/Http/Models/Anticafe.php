<?php
namespace Anticafe\Http\Models;


use Anticafe\Http\Interfaces\ModelNameable;
use Anticafe\Http\Services\ImageProcessor;
use Anticafe\Http\Traits\ListTrait;
use Carbon\Carbon;
use Helpers\ImageHandler\ImageableTrait;
use Helpers\ImageHandler\ImageRepository;
use Helpers\Roles\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;

class Anticafe extends Model implements ModelNameable
{
    use SoftDeletes, ImageableTrait, ListTrait;

    protected $table = "anticafes";

    protected $guarded = [];

    protected $dates = ['deleted_at', 'start_at', 'end_at'];

    private $modulename;

    private static $rules = [
        "pincode" => "sometimes|required|numeric",
        "name" => "required",
        "prices" => "required",
        'logo' => 'sometimes|required|image|image_size:<=300',
    ];

    /**
     * GETing methods
     * @return mixed
     */

    public function scopeOrdered($query)
    {
        return $query->where('id', ">", 0)->orderBy('type', 'asc');
    }
    
    // TODO: заменить на skope

    public static function getAnticafes()
    {
        if(can('anticafe.see.all')){
            $anticafe = static::where('type', 0);
        } elseif(can('anticafe.see.own')){
            $anticafe = auth()->user()->Anticafes();
        } else {
            $anticafe = null;
        }
        return $anticafe;
    }

    public static function getEvents()
    {
        if(can('events.see.all')){
            $events = static::where('type', 1);
        } elseif(can('events.see.own')){
            $events = auth()->user()->Events();
        } else {
            $events = null;
        }
        return $events;
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

    public static function activeEvents($collection)
    {
        $c = collect();
        foreach($collection as $w) {
            if($w->start_at > Carbon::now()) $c->push($w);
        }

        return $c;
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
        return $this->belongsToMany(Client::class, 'likes', 'anticafe_id', 'client_id');
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

    public function Operators()
    {
        $users = $this->Users;
        $c = collect();
        foreach ($users as $user) {
            $role = Role::firstOrCreate(['name' => "Оператор заявок"]);
            $user->hasRole($role->id) ? $c->push($user) : null;
        }
        return $c;
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
            $entity->attachManager();
        }

        $entity->attachTags($request->input('tags'));

        $entity->setPromo($request->input('promo'));
        $entity->setBookingAvailable($request->input('booking_available'));

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
        }

        $this->attachTags($request->input('tags'));

        $this->setPromo($request->input('promo'));
        $this->setBookingAvailable($request->input('booking_available'));

        if($request->input('_session') != null)
            ImageRepository::saveFromSession($this, $request->input('_session'));

        return $this;
    }

    public function setModelName()
    {
        return $this->modulename = "Антикафе";
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

//        dd($this, $this->images());

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

    private function attachManager()
    {
        $this->Users()->attach(\Auth::id());
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

    public function incrementBookingCount()
    {
        $this->total_bookings += 1;
        $this->save();
    }
}