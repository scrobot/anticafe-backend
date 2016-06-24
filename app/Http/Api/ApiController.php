<?php

namespace Anticafe\Http\Api;

use Anticafe\Http\Controllers\Controller;
use Anticafe\Http\Models\Client;
use Illuminate\Http\Request;

class ApiController extends Controller
{

    private $response;
    private $request;

    /**
     * ApiController constructor.
     * @param Request $request
     * @internal param array $result
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->response = new Response(Client::where('authToken', $request->header("authToken"))->first());
    }

    /**
     * Start activity api request method.
     * @method GET
     * @return \Illuminate\Http\JsonResponse
     */
    public function getHome()
    {
        return response()->json($this->response->home());
    }

    /**
     * Authentication with Vkontakte API
     * @method POST
     * @return \Illuminate\Http\JsonResponse
     */
    public function postVk()
    {
        return response()->json($this->response->vk($this->request->only('uid', 'access_token')));        
    }

    /**
     * Anticafe catalog activity
     * @param int $offset
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAnticafes($offset = 0)
    {
        return response()->json($this->response->anticafeCatalog($offset));
    }

    /**
     * Events catalog activity
     * @param int $offset
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents($offset = 0)
    {
        return response()->json($this->response->eventsCatalog($offset));
    }
}