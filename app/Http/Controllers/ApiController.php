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
use Anticafe\Http\Models\Tag;
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
        }

        $this->response['client'] = $client;
        return response()->json($this->response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFb(Request $request)
    {
        $uid = $request->input('uid');
        $access_token = $request->input('access_token');

        $guzzle = new \GuzzleHttp\Client();
        $response = $guzzle->request("GET", "https://graph.facebook.com/v2.5/{$uid}?access_token={$access_token}&fields=id,email,first_name,last_name,picture");
        $response = json_decode($response->getBody()->getContents());

        $client = Client::where('fb_uid', $response->id)->first();

        if($client == null) {
            $client = new Client();
            $client->authToken = str_random(32);
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
        }

        $this->response['client'] = $client;
        return response()->json($this->response);
    }

    /**
     * @param int $count
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMain($count = 0)
    {
        $this->response["anticafe"] = $this->api->getBestAnticafes($count, 16);
        $this->response["tags"] = $this->api->getTagGroups();

        if($this->client != null) {
            $this->response["bookings"] = $this->api->getBookings($this->client);
        }

        return response()->json($this->response);
    }

    /**
     * @param int $count
     * @param int $limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnticafes($count = 0, $limit = 16)
    {
        $this->response["anticafe"] = $this->api->getAnticafes($count, $limit);

        return response()->json($this->response);
    }

    /**
     * @param int $count
     * @param int $limit
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents($count = 0, $limit = 16)
    {
        $this->response["anticafe"] = $this->api->getEvents($count, $limit);

        return response()->json($this->response);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGetOneAnticafeOrEvent($id)
    {
        return response()->json($this->api->getGetOneAnticafeOrEvent($id));
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->api->getTagGroups();
    }

    /**
     * @return mixed
     */
    public function getAbilities()
    {
        return $this->api->getAbilities();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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
                "fb_token" => $this->client->fb_token,
                "coupon" => $this->client->coupon,
                "coupon_repaid" => $this->client->coupon_repaid,
            ];
            $this->response['client']["likes"] = $this->api->getLikes($this->client);
            $this->response['client']["bookings"] = $this->api->getBookings($this->client);
        }

        return response()->json($this->response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function postProfileUpdate(Request $request)
    {
        if($this->client == null) {
            return $this->error();
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSearch(Request $request)
    {
        $searchable = $request->input('search_text');

        $this->response["searchResult"]['anticafes_and_events'] = $this->api->getSearchedAnticafes($searchable);

        return response()->json($this->response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postFindByTag(Request $request) {
        $tag_id = $request->input('tag_id');

        $this->response["searchResult"]["anticafes_and_events"] = $this->api->getSearchedAnticafesByTag($tag_id);

        return response()->json($this->response);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function getClientBooking($id)
    {
        if($this->client == null) {
            return $this->error();
        } else {
            $this->response["booking"] = $this->api->getBooking(null, $id);
        }
        return response()->json($this->response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function postBooking(Request $request)
    {
        $no_problem = false;

        if($this->client == null) {
            return $this->error();
        }

        $anticafe = Anticafe::find($request->input('anticafe_id'));

        if(!$anticafe->Operators()->count()) {
            abort(500);
        }

        $booking = new Booking();
        $booking->count_of_customers = $request->input('count_of_customers');
        $booking->comment = $request->input('comment') == null ? "" : $request->input('comment');
        $booking->contacts = $request->input('contacts');
        $booking->status = $request->input('status')== null ? "process" : $request->input('status');
        $booking->arrival_at = $request->input('arrival_at');
        $booking->anticafe_id = $anticafe->id;
        $booking->client_id = $this->client->id;
        $booking->user_id = $anticafe->Operators()->first()->id;
        if($booking->save()){
            $no_problem = true;
        };

        foreach ($anticafe->Operators() as $operator) {
            $operator->sendEmailNotification($booking);
        }

        $booking->Client->sendEmailNotification($booking, $booking->status);

        $anticafe->incrementBookingCount();

        if($no_problem) {
            return response($this->response);
        }

        return response($this->response)->withHeaders([
            "Status Code" => 500,
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function getDeleteBooking($id)
    {
        if($this->client == null) {
            return $this->error();
        } else {
            Booking::destroy($id);
            $this->response['deleted'] = true;
        }
        return response($this->response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function postLike(Request $request)
    {
        if($this->client == null) {
            return $this->error();
        }

        $anticafe = Anticafe::find($request->input('anticafe_id'));
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function postPrepaid(Request $request)
    {
        if($this->client == null) {
            return $this->error();
        }
        
        $anticafe = Anticafe::findByPincode($request->only("pincode"))->first();

        if($anticafe != null) {
            $this->client->coupon = null;
            $this->client->coupon_repaid = 1;
            $this->client->save();
            $this->response['needAuth'] = true;
            $this->response['message'] = "Код успешно погашен";

            return response()->json($this->response);
        }

        return $this->error(500, "Неверный пинкод");
    }

    /**
     * @return mixed
     */
    public function documentation()
    {
        return view('api.doc')->withTitle("Документация")->withErrors([]);
    }

    /**
     * @param int $code
     * @param string $message
     * @param bool $needAuth
     * @return mixed
     * @internal param string $messsage
     */
    private function error($code = 403, $message = "Вы не авторизованы и не имеете доступа к данному запросу", $needAuth = true)
    {
        $this->response['status'] = $code;
        $this->response['error'] = true;
        $this->response['needAuth'] = $needAuth;
        $this->response['message'] = $message;
        return response($this->response, $code);
    }

}