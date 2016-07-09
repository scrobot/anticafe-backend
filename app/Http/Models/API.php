<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 09.03.2016
 * Time: 12:24
 */

namespace Anticafe\Http\Models;


use Anticafe\Http\Models\Client;
use Carbon\Carbon;

class API
{

    private $images = [];

    public function getAnticafes($count = 0, $limit = 15)
    {
        $anticafes = Anticafe::where('type', 0)->orderBy("promo", "desc")->orderBy("total_likes", "desc");
        if($count != 0 && $limit != 0) {
            $anticafes->skip($count)->take($limit);
        }

        $anticafes = $anticafes->get();

        foreach ($anticafes as $anticafe) {
            $anticafe->tags = $anticafe->Tags->toArray();
            $anticafe->events = $anticafe->Events->toArray();
            $anticafe->attachments = $this->setImages($anticafe);
            unset($anticafe->images);
        }

        return $anticafes;
    }

    public function getBestAnticafes($count, $limit)
    {
        $anticafes = Anticafe::where('id', ">=", 0)->orderBy("promo", "desc")->orderBy("total_likes", "desc")->skip($count)->take($limit)->get();

        foreach ($anticafes as $anticafe) {
            $anticafe->attachments = $this->setImages($anticafe);
            unset($anticafe->images);
        }

        return $anticafes;
    }

    public function getTagGroups() {
        return Tag::homeTags()->get();
    }

    public function getAbilities() {
        $abilites = Tag::abilites()->get();

        foreach ($abilites as $ability) {
            $ability->tag = $ability->Group->name;
        }

        return $abilites;
    }

    public function getEvents($count = 0, $limit = 15)
    {
        $events = Anticafe::where('type', 1)->orderBy("promo", "desc");
        if($count != 0 && $limit != 0) {
            $events->skip($count)->take($limit);
        }

        $events = Anticafe::activeEvents($events->get());

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
        $anticafe->tags = $anticafe->setTags();
        $anticafe->attachments = $this->setImages($anticafe);
        if($anticafe->type == 0) {
            $anticafe->events = $anticafe->Events->toArray();
        } else {
            $anticafe->anticafes = $anticafe->Anticafes->toArray();
            $anticafe->start = $anticafe->start_at->toDateTimeString();
            $anticafe->end = $anticafe->end_at->toDateTimeString();
        }
        unset($anticafe->images);
        return $anticafe;

    }

    public function getBookings(Client $client) {
        $bookings = [];

        $sorted = $client->Bookings->sortBy('arrival_at');

//        dd($sorted);

        foreach ($sorted->values()->all() as $book) {
            $book = $this->getBooking($book);
            if($book != null) {
                $bookings[] = $book;
            }
        }

        return $bookings;
    }

    public function getBooking(Booking $book = null, $id = null)
    {
        if($id != null && $book == null) {
            $book = Booking::find($id);
            if($book == null) return null;
        }

//        dd(Carbon::now()->timestamp, $book->getArrivalTimestamp(), Carbon::now()->timestamp > $book->getArrivalTimestamp());

        if(Carbon::now()->timestamp > $book->getArrivalTimestamp()) {
            return null;
        }

/*        if($book->status == "declined") {
            return null;
        }*/

        return [
            "id" => $book->id,
            "anticafe" => $book->Anticafe->name,
            "address" => $book->Anticafe->address,
            "type" => $book->Anticafe->type == 0 ? "Антикафе" : "Событие",
            "arrivalAt" => $book->arrival_at,
            "countOfCustomers" => $book->count_of_customers,
            "comment" => $book->comment,
            "status" => config("statuses.{$book->status}"),
            "anticafe_id" => $book->Anticafe->id,
        ];
    }

    private function setImages($anticafe)
    {
        $images = [
            'logo' => "http://backend.anticafe.im/images/anticafes/logos/{$anticafe->logo}",
            'cover' => "http://backend.anticafe.im/images/anticafes/covers/{$anticafe->cover}"
        ];
        $images['gallery'] = [];

        foreach ($anticafe->images as $gallery) {
            array_push($images['gallery'], "http://backend.anticafe.im/images/anticafes/gallery/".strtolower($gallery->original_name));
        }


        return $images;
    }

    public function getLikes(Client $client)
    {
        $likes = [];

        foreach ($client->Likes as $anticafe) {
            $anticafe->tags = $anticafe->Tags->toArray();
            $anticafe->events = $anticafe->Events->toArray();
            $anticafe->attachments = $this->setImages($anticafe);
            unset($anticafe->images);
            $likes[] = $anticafe;
        }

        return $likes;
    }

    public function getSearchedAnticafesByTag($tag_id)
    {
        $tag = Tag::find($tag_id);

        $result = $tag->Anticafes;

        foreach ($result as $anticafe) {
            $anticafe->attachments = $this->setImages($anticafe);
            unset($anticafe->images);
        }

        return $result;
    }

    public function getSearchedAnticafes($searchable)
    {
        $result = collect();
        $result->push(Anticafe::where("name", "LIKE", "%{$searchable}%")
            ->orWhere("address", "LIKE", "%{$searchable}%")
            ->orWhere("excerpt", "LIKE", "%{$searchable}%")
            ->orWhere("description", "LIKE", "%{$searchable}%")
            ->orderBy("total_likes", "desc")
            ->get());

        $q = Anticafe::whereHas('Tags', function($q) use ($searchable)
        {
            $q->where('name', 'like', "%{$searchable}%");

        })->orWhereHas('Tags.Aliases', function($q) use ($searchable)
        {
            $q->where('name', 'like', "%{$searchable}%")->orWhere('name', $searchable);

        })
            ->orderBy("total_likes", "desc")
            ->get();

        foreach($q as $e) {
            if($result->contains("id", $e->id)) {
                continue;
            }
            $result->push($e);
        }

        $result = $result[0];

        foreach ($result as $anticafe) {
            $anticafe->attachments = $this->setImages($anticafe);
            unset($anticafe->images);
        }

        return $result;
    }


}