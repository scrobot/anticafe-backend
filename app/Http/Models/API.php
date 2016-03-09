<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 09.03.2016
 * Time: 12:24
 */

namespace Anticafe\Http\Models;


class API
{

    private $images = [];

    public function getAnticafes($count = 0)
    {
        $anticafes = Anticafe::where('type', 0)->skip($count)->take(15)->get();

        foreach ($anticafes as $anticafe) {
            $anticafe->tags = $anticafe->Tags->toArray();
            $anticafe->events = $anticafe->Events->toArray();
            $anticafe->attachments = $this->setImages($anticafe);
            unset($anticafe->images);
        }

        return $anticafes;
    }

    public function getTagGroups() {
        return Tag::groups()->get();
    }

    public function getAbilities() {
        $abilites = Tag::abilites()->get();

        foreach ($abilites as $ability) {
            $ability->tag = $ability->Group->name;
        }

        return $abilites;
    }

    public function getEvents($count = 0)
    {
        $events = Anticafe::where('type', 1)->skip($count)->take(15)->get();

        foreach ($events as $event) {
            $event->tags = $event->Tags->toArray();
            $event->anticafes = $event->Anticafes->toArray();
            $event->attachments = $this->setImages($event);
        }

        return $events;
    }

    public function getGetOneAnticafeOrEvent($id)
    {
        $anticafe = Anticafe::find($id);
        $anticafe->total_views++;
        $anticafe->save();
        // TODO: отрефакторить. Возможно засунуть в модель.
        $anticafe->tags = $anticafe->Tags->toArray();
        $anticafe->attachments = $this->setImages($anticafe);
        if($anticafe->type == 0)
            $anticafe->events = $anticafe->Events->toArray();
        else
            $anticafe->anticafes = $anticafe->Anticafes->toArray();
        unset($anticafe->images);
        return $anticafe;

    }

    public function getProfile($id)
    {
        $client = Client::find($id);
        $client->bookings = $client->Bookings->toArray();
        $client->likes = $client->Likes->toArray();

        return $client;
    }

    private function setImages($anticafe)
    {
        $images = [
            'logo' => "http://backend.anticafe.im/images/anticafes/logos/{$anticafe->logo}",
            'cover' => "http://backend.anticafe.im/images/anticafes/covers/{$anticafe->cover}"
        ];
        $images['gallery'] = [];

        foreach ($anticafe->images as $gallery) {
            array_push($images['gallery'], "http://backend.anticafe.im/images/anticafes/gallery/{$gallery->original_name}");
        }


        return $images;
    }

}