<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 17.02.2016
 * Time: 12:43
 */

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Anticafe;
use Anticafe\Http\Models\Booking;
use Anticafe\Http\Models\Client;
use Anticafe\Http\Models\Tag;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    private $result = [];

    public function getMain()
    {

    }

    public function getAnticafes($limit = 15)
    {
        $anticafes = Anticafe::where('type', 0)->take($limit)->get();

        foreach ($anticafes as $anticafe) {
            $anticafe->tags = $anticafe->Tags->toArray();
            $anticafe->events = $anticafe->Events->toArray();
        }

        return response()->json($anticafes);
    }

    public function getEvents($limit = 15)
    {
        $events = Anticafe::where('type', 1)->take($limit)->get();

        foreach ($events as $event) {
            $event->tags = $event->Tags->toArray();
            $event->anticafes = $event->Anticafes->toArray();
        }

        return response()->json($events);
    }

    public function getGetOneAnticafeOrEvent($id)
    {
        $anticafe = Anticafe::find($id);
        $anticafe->total_views++;
        $anticafe->save();
        // TODO: отрефакторить. Возможно засунуть в модель.
        $anticafe->tags = $anticafe->Tags->toArray();
        if($anticafe->type == 0)
            $anticafe->events = $anticafe->Events->toArray();
        else
            $anticafe->anticafes = $anticafe->Anticafes->toArray();

        return response()->json($anticafe);

    }

    public function getProfile($id)
    {
        $client = Client::find($id);
        $client->bookings = $client->Bookings->toArray();
        $client->likes = $client->Likes->toArray();

        return response()->json($client);
    }

    public function postSearch(Request $request)
    {
        $searchable = $request->input('search_text');
        $this->result['anticafes_and_events'] = Anticafe::where("name", "LIKE", "%{$searchable}%")
                                                        ->orWhere("address", "LIKE", "%{$searchable}%")
                                                        ->orWhere("excerpt", "LIKE", "%{$searchable}%")
                                                        ->orWhere("description", "LIKE", "%{$searchable}%")
                                                        ->get();
        $this->result['finded_by_tags_and_aliases'] = Anticafe::whereHas('Tags', function($q) use ($searchable)
        {
            $q->where('name', 'like', "%{$searchable}%");

        })->orWhereHas('Tags.Aliases', function($q) use ($searchable)
        {
            $q->where('name', 'like', "%{$searchable}%")->orWhere('name', $searchable);

        })->get();

        return response()->json($this->result);
    }

    public function getClientBooking($id)
    {
        $booking = Booking::find($id);
        $booking->anticafe = $booking->Anticafe->toArray();
        return response()->json($booking);
    }

    public function postBooking(Request $request)
    {
        $booking = new Booking();
        $booking->count_of_customers = $request->input('count_of_customers');
        $booking->comment = $request->input('comment');
        $booking->contacts = $request->input('contacts');
        $booking->status = $request->input('status');
        $booking->arrival_at = $request->input('arrival_at');
        $booking->anticafe_id = $request->input('anticafe_id');
        $booking->client_id = $request->input('client_id');
        $booking->user_id = 1;
        $booking->save();

        return response('OK', 200);
    }

    public function getDeleteBooking($id)
    {
        Booking::destroy($id);

        return response('OK', 200);
    }

    public function postLike(Request $request)
    {
        $client = Client::where('token', $request->input('token'))->first();
        $anticafe = Anticafe::find($request->input('anticafe_id'));
        if($client->Likes->contains($anticafe->id)) {
            $client->Likes()->detach($anticafe->id);
            $anticafe->total_likes--;
            $status = "unliked";
        } else {
            $client->Likes()->attach($anticafe->id);
            $anticafe->total_likes++;
            $status = "liked";
        }

        $anticafe->save();

        return response($status, 200);
    }


}