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
            'original' => [
                'logo' => "/images/anticafes/logos/{$anticafe->logo}",
                'cover' => "/images/anticafes/covers/{$anticafe->cover}"
            ]
        ];
        $images['gallery'] = $anticafe->images;
        foreach (ImageOption::all() as $item) {
            $images[$item->name] = [
                'logo' => "/images/anticafes/logos/{$item->name}/{$item->name}_{$anticafe->logo}",
                'cover' => "/images/anticafes/covers/{$item->name}/{$item->name}_{$anticafe->cover}"
            ];
        }

        return $images;
    }

}