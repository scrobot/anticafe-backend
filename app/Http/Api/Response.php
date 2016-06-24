<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 24.06.2016
 * Time: 14:37
 */

namespace Anticafe\Http\Api;


use Anticafe\Http\Models\API;
use Anticafe\Http\Models\Client;

class Response
{

    /**
     * @var API
     */
    private $api;

    private $requestBody;
    /**
     * @var int
     */
    public $status = 200;

    /**
     * @var boolean
     */
    public $error = false;

    /**
     * @var boolean
     */
    public $needAuth = false;

    /**
     * @var string
     */
    public $message = "";

    /**
     * @var array
     */
    public $validation_messages = [];

    /**
     * @var Client
     */
    public $client;

    /**
     * @var Body
     */
    public $body;

    /**
     * Response constructor.
     * @param $client
     */
    public function __construct($client)
    {
        $this->client = $client;
        $this->api = new API();
        $this->body = new Body();
    }

    /**
     * Start activity api request method.
     * @return $this
     */
    public function home()
    {
        $this->body->anticafe = $this->api->getBestAnticafes(0, 16);
        $this->body->tags = $this->api->getTagGroups();

        if($this->client != null) {
            $this->body->bookings = $this->api->getBookings($this->client);
        }

        return $this;
    }


    /**
     * Find or Create client by vk user id
     * @param array $request
     * @return $this
     */
    public function vk(array $request)
    {
        $this->client = Client::where('vk_uid', $request['uid'])->first();
        $this->requestBody = json_decode((new \GuzzleHttp\Client())->request("GET", "https://api.vk.com/method/users.get?user_id={$request['uid']}&fields=photo_50")->getBody()->getContents());

        if($this->client == null) {
            $client = new Client();
            $client->authToken = str_random(32);
            $client->first_name = $this->requestBody->response[0]->first_name;
            $client->last_name = $this->requestBody->response[0]->last_name;
            $client->avatar = $this->requestBody->response[0]->photo_200;
            $client->vkontakte = 1;
            $client->vk_uid = $this->requestBody->response[0]->uid;
            $client->vk_token = $request['access_token'];
            $client->save();
        }

        return $this;
    }

    public function anticafeCatalog($offset)
    {
        $this->body->anticafe = $this->api->getAnticafes($offset, 16);

        return $this;
    }

    public function eventsCatalog($offset)
    {
        $this->body->events = $this->api->getEvents($offset, 16);

        return $this;
    }
}