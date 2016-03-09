<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 17.02.2016
 * Time: 12:43
 */

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Anticafe;
use Anticafe\Http\Models\API;
use Anticafe\Http\Models\Booking;
use Anticafe\Http\Models\Client;
use Anticafe\Http\Models\ImageOption;
use Anticafe\Http\Models\Tag;
use Illuminate\Http\Request;

class ApiController extends Controller
{



    private $result = [];
    private $api;

    /**
     * ApiController constructor.
     * @param array $result
     */
    public function __construct()
    {
        $this->api = new API();
    }

    public function getMain()
    {
        return [
            "anticafe" => $this->api->getAnticafes(),
            "tags" => $this->api->getTagGroups()
        ];
    }

    public function getAnticafes($count = 0)
    {
        return response()->json($this->api->getAnticafes($count));
    }

    public function getEvents($count = 0)
    {
        return response()->json($this->api->getEvents($count));
    }

    public function getGetOneAnticafeOrEvent($id)
    {
        return response()->json($this->api->getGetOneAnticafeOrEvent($id));
    }

    public function getTags()
    {
        return $this->api->getTagGroups();
    }

    public function getAbilities()
    {
        return $this->api->getAbilities();
    }

    public function getProfile($id)
    {
        return response()->json($this->api->getProfile($id));
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
        $anticafe = Anticafe::find($request->input('anticafe_id'));

        $booking = new Booking();
        $booking->count_of_customers = $request->input('count_of_customers');
        $booking->comment = $request->input('comment');
        $booking->contacts = $request->input('contacts');
        $booking->status = $request->input('status');
        $booking->arrival_at = $request->input('arrival_at');
        $booking->anticafe_id = $anticafe->id;
        $booking->client_id = $request->input('client_id');
        $booking->user_id = $anticafe->Manager()->id;
        $booking->save();

        $anticafe->Manager()->sendEmailNotification($booking);

        return response('OK', 200);
    }

    public function getDeleteBooking($id)
    {
        Booking::destroy($id);

        return response('OK', 200);
    }

    public function postLike(Request $request)
    {
        $client = Client::find($request->input('client_id'));
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

    public function documentation()
    {
        return view('api.doc')->withTitle("Документация")->withErrors([]);
    }

}