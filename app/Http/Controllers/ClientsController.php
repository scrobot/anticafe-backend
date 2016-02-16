<?php

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Client;

class ClientsController extends Controller
{

    private $title;

    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = "Клиенты";
    }

    public function getIndex()
    {
        return view('clients.list')->withClients(Client::paginate(15))->withTitle($this->title);
    }

    public function getShow($id)
    {
        return view('clients.show')->withClient(Client::find($id))->withTitle($this->title);
    }

    public function getDestroy($id)
    {
        Client::destroy($id);
        return back()->withMsg('common.msg.delete');
    }


}