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
use Illuminate\Http\Request;

class ApiController extends Controller
{

    private $client;
    private $api;
    private $response;

    /**
     * ApiController constructor.
     * @param Request $request
     * @internal param array $result
     */
    public function __construct(Request $request)
    {
        $this->api = new API();
        $this->client = Client::where('authToken', $request->header("authToken"))->first();
        $this->response = [
            "status" => 200,
            "error" => false
        ];
    }

    public function getMain()
    {
        $this->response["anticafe"] = $this->api->getAnticafes();
        $this->response["tags"] = $this->api->getTagGroups();

        if($this->client != null) {
            $this->response["bookings"] = $this->api->getBookings($this->client);
        }

        return response()->json($this->response);
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

    public function getClient() {
        if($this->client != null) {
            $this->response['client'] = $this->client;
        }
        return response()->json($this->response);
    }

    public function getProfile()
    {
        if($this->client != null) {
            $this->response['bookings'] = $this->api->getBookings($this->client);
        }
        return response()->json($this->response);
    }

    public function postSearch(Request $request)
    {
        $searchable = $request->input('search_text');
        $this->response['anticafes_and_events'] = Anticafe::where("name", "LIKE", "%{$searchable}%")
                                                        ->orWhere("address", "LIKE", "%{$searchable}%")
                                                        ->orWhere("excerpt", "LIKE", "%{$searchable}%")
                                                        ->orWhere("description", "LIKE", "%{$searchable}%")
                                                        ->get();
        $this->response['finded_by_tags_and_aliases'] = Anticafe::whereHas('Tags', function($q) use ($searchable)
        {
            $q->where('name', 'like', "%{$searchable}%");

        })->orWhereHas('Tags.Aliases', function($q) use ($searchable)
        {
            $q->where('name', 'like', "%{$searchable}%")->orWhere('name', $searchable);

        })->get();

        return response()->json($this->response);
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
        $anticafe = Anticafe::find($request->input('anticafe_id'));
        if($this->client->Likes->contains($anticafe->id)) {
            $this->client->Likes()->detach($anticafe->id);
            $anticafe->total_likes--;
            $status = "unliked";
        } else {
            $this->client->Likes()->attach($anticafe->id);
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