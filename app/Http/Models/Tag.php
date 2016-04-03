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
use Intervention\Image\ImageManager;
use Stringy\StaticStringy;
use Symfony\Component\HttpFoundation\File\File;

class Tag extends Model implements ModelNameable
{

    private $name;

    protected $table = 'tags';

    protected $guarded = [];

    public $timestamps = false;

    public static function uploadIcon(File $file, Tag $tag = null)
    {
        if($file != null) {
            $image = (new ImageManager())->make($file)->encode("png")->resize(125, 125);
            $name = public_path() . '/images/icons/tags/' . md5($file->getClientOriginalName()) . ".png";
            $image->save($name);
            return url("/") . DIRECTORY_SEPARATOR . '/images/icons/tags/' . md5($file->getClientOriginalName()) . ".png";
        }

        if($tag != null) {
            return $tag->icon;
        }

        return url("/") . DIRECTORY_SEPARATOR . "/images/default-icon.png";
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = StaticStringy::slugify($value);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('name', 'asc');
    }

    public function scopeGroups($query)
    {
        return $query->where("is_group", 1);
    }

    public function scopeHomeTags($query)
    {
        return $query->whereIn("slug", ['chay-i-kofe', 'nastolki', 'muzyka', 'internet', 'lektsii', 'pristavki', 'obshchenie', 'prochee']);
    }

    public function scopeAbilites($query)
    {
        return $query->where("is_group", 0)->where("parent_id", ">", 0);
    }

    public function scopeAlones($query)
    {
        return $query->where('parent_id', NULL)->where('is_group', 0);
    }

    public function Aliases()
    {
        return $this->belongsToMany(Alias::class);
    }

    public function Anticafes()
    {
        return $this->belongsToMany(Anticafe::class);
    }

    public function Group()
    {
        return $this->belongsTo(static::class, "parent_id", "id");
    }

    public function Children()
    {
        return $this->hasMany(static::class, "parent_id", "id");
    }

    public function setModelName()
    {
        return $this->name = "Возможности";
    }

    public static function getModelName()
    {
        return (new static)->setModelName();
    }

    public function syncWithAliases($aliases)
    {
        $aliases = $aliases == null ? [] : $this->searchOrCreate($aliases);
        $this->Aliases()->sync($aliases);
    }

    private function searchOrCreate($aliases)
    {
        $arr = [];

        foreach ($aliases as $alias) {
            if(empty($alias)) continue;
            $al = Alias::firstOrNew(['name' => $alias]);
            $al->slug = $alias;
            $al->save();
            $arr[] = $al->id;
        }

        return $arr;
    }
}