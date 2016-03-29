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
            "error" => false,
            "needAuth" => false,
            "message" => "",
        ];
    }

    public function postVk(Request $request)
    {
        $uid = $request->input('uid');

        $client = Client::where('vk_uid', $uid)->first();

        $guzzle = new \GuzzleHttp\Client();
        $response = $guzzle->request("GET", "https://api.vk.com/method/users.get?user_id={$uid}&fields=photo_50");
        $response = json_decode($response->getBody()->getContents());

        if($client == null) {
            $client = new Client();
            $client->authToken = str_random(32);
        }

        $client->first_name = $response->response[0]->first_name;
        $client->last_name = $response->response[0]->last_name;
        $client->avatar = $response->response[0]->photo_50;
        $client->vkontakte = 1;
        $client->vk_uid = $response->response[0]->uid;
        $client->vk_token = $request->input('access_token');
        $client->facebook = 0;
        $client->fb_uid = null;
        $client->fb_token = null;
        $client->save();

        $this->response['client'] = $client;
        return response()->json($this->response);
    }

    public function postFb(Request $request)
    {
        $uid = $request->input('uid');
        $access_token = $request->input('access_token');

        $client = Client::where('fb_uid', $uid)->first();

        $guzzle = new \GuzzleHttp\Client();
        $response = $guzzle->request("GET", "https://graph.facebook.com/v2.5/{$uid}?access_token={$access_token}&fields=id,email,first_name,last_name,picture");
        $response = json_decode($response->getBody()->getContents());

        if($client == null) {
            $client = new Client();
            $client->authToken = str_random(32);
        }

        $client->first_name = $response->first_name;
        $client->last_name = $response->last_name;
        $client->avatar = $response->picture->data->url;
        $client->vkontakte = 0;
        $client->vk_uid = null;
        $client->vk_token = null;
        $client->facebook = 1;
        $client->fb_uid = $response->id;
        $client->fb_token = $access_token;
        $client->save();

        $this->response['client'] = $client;
        return response()->json($this->response);
    }

    public function postAddVkProfileToUser(Request $request)
    {
        $client = Client::find($request->input('id'));

        $uid = $request->input('uid');
        $access_token = $request->input('access_token');

        $guzzle = new \GuzzleHttp\Client();
        $response = $guzzle->request("GET", "https://api.vk.com/method/users.get?user_id={$uid}&fields=photo_50");
        $response = json_decode($response->getBody()->getContents());

        $client->vkontakte = 1;
        $client->vk_uid = $response->response[0]->uid;
        $client->vk_token = $access_token;
        $client->save();

        $this->response['client'] = $client;
        return response()->json($this->response);
    }


    public function postAddFbProfileToUser(Request $request)
    {
        $client = Client::find($request->input('id'));

        $uid = $request->input('uid');
        $access_token = $request->input('access_token');

        $guzzle = new \GuzzleHttp\Client();
        $response = $guzzle->request("GET", "https://graph.facebook.com/v2.5/{$uid}?access_token={$access_token}&fields=id,email,first_name,last_name,picture");
        $response = json_decode($response->getBody()->getContents());

        $client->facebook = 1;
        $client->fb_uid = $response->id;
        $client->fb_token = $access_token;
        $client->save();

        $this->response['client'] = $client;
        return response()->json($this->response);
    }

    public function getMain($count = 0)
    {
        $this->response["anticafe"] = $this->api->getBestAnticafes($count, 16);
        $this->response["tags"] = $this->api->getTagGroups();

        if($this->client != null) {
            $this->response["bookings"] = $this->api->getBookings($this->client);
        }

        return response()->json($this->response);
    }

    public function getAnticafes($count = 0, $limit = 16)
    {
        $this->response["anticafe"] = $this->api->getAnticafes($count, $limit);

        return response()->json($this->response);
    }

    public function getEvents($count = 0, $limit = 16)
    {
        $this->response["anticafe"] = $this->api->getEvents($count, $limit);

        return response()->json($this->response);
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

    public function getProfile()
    {
        if($this->client != null) {
            $this->response['client'] = [
                "id" => $this->client->id,
                "first_name" => $this->client->first_name,
                "last_name" => $this->client->last_name,
                "phone" => $this->client->phone,
                "email" => $this->client->email,
                "avatar" => $this->client->avatar,
                "get_notifications" => $this->client->get_notifications,
                "get_news" => $this->client->get_news,
                "social_profile_link" => $this->client->social_profile_link,
                "authToken" => $this->client->authToken,
                "vkontakte" => $this->client->vkontakte ? 1 : 0,
                "facebook" => $this->client->facebook ? 1 : 0,
                "vk_uid" => $this->client->vk_uid,
                "fb_uid" => $this->client->fb_uid,
                "vk_token" => $this->client->vk_token,
                "fb_token" => $this->client->fb_token
            ];
            $this->response['client']["likes"] = $this->api->getLikes($this->client);
            $this->response['client']["bookings"] = $this->api->getBookings($this->client);
        }

        return response()->json($this->response);
    }

    public function postProfileUpdate(Request $request)
    {
        if($this->client == null) {
            $this->response['status'] = 500;
            $this->response['error'] = true;
            $this->response['message'] = "Произошла ошибка при обновлении профиля.";
            return response()->json($this->response);
        }

        $cl = Client::find($this->client->id);
        $cl->first_name = $request->input('first_name');
        $cl->last_name = $request->input('last_name');
        $cl->email = $request->input('email');
        $cl->phone = $request->input('phone');
        $cl->save();

        $this->response['message'] = "Профиль успешно обновлен";

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
        if($this->client == null) {
            $this->response['status'] = 403;
            $this->response['error'] = true;
            $this->response['needAuth'] = true;
            $this->response['message'] = "Вы не авторизованы и не имеете доступа к данному запросу";
        } else {
            $this->response["booking"] = $this->api->getBooking(null, $id);
        }
        return response()->json($this->response);
    }

    public function postBooking(Request $request)
    {
//        dd($this->client);
        if($this->client == null) {
            $this->response['status'] = 403;
            $this->response['error'] = true;
            $this->response['needAuth'] = true;
            $this->response['message'] = "Вы не авторизованы и не имеете доступа к данному запросу";
            return response()->json($this->response);
        }

        $anticafe = Anticafe::find($request->input('anticafe_id'));

        $booking = new Booking();
        $booking->count_of_customers = $request->input('count_of_customers');
        $booking->comment = $request->input('comment');
        $booking->contacts = $request->input('contacts');
        $booking->status = $request->input('status')== null ? "process" : $request->input('status');
        $booking->arrival_at = $request->input('arrival_at');
        $booking->anticafe_id = $anticafe->id;
        $booking->client_id = $this->client->id;
        $booking->user_id = $anticafe->Manager()->id;
        $booking->save();

        $anticafe->Manager()->sendEmailNotification($booking);

        return response($this->response);
    }

    public function getDeleteBooking($id)
    {
        if($this->client == null) {
            $this->response['status'] = 403;
            $this->response['error'] = true;
            $this->response['needAuth'] = true;
            $this->response['message'] = "Вы не авторизованы и не имеете доступа к данному запросу";
        } else {
            Booking::destroy($id);
            $this->response['deleted'] = true;
        }
        return response($this->response);
    }

    public function postLike(Request $request)
    {
        if($this->client == null) {
            $this->response['status'] = 403;
            $this->response['error'] = true;
            $this->response['needAuth'] = true;
            $this->response['message'] = "Вы не авторизованы и не имеете доступа к данному запросу";
            return response($this->response);
        }

//        dd($request->input('anticafe_id'));

        $anticafe = Anticafe::find($request->input('anticafe_id'));
//        dd($request->input('anticafe_id'), Anticafe::find(3), $anticafe);
//        dd($this->client->Likes->contains($anticafe->id));
        if($this->client->Likes->contains($anticafe->id)) {
            $this->client->Likes()->detach($anticafe->id);
            $anticafe->total_likes--;
            $this->response['likeStatus'] = "unliked";
        } else {
            $this->client->Likes()->attach($anticafe->id);
            $anticafe->total_likes++;
            $this->response['likeStatus'] = "liked";
        }

        $anticafe->save();
        $this->response["totalLikes"] = $anticafe->total_likes;

        return response($this->response);
    }

    public function documentation()
    {
        return view('api.doc')->withTitle("Документация")->withErrors([]);
    }

}