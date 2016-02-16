<?php

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Anticafe;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    private $title;

    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = "События";
    }

    public function getIndex()
    {
        $query = Anticafe::getEvents()->paginate(15);

        return view('events.list')->withEvents($query)->withTitle($this->title);
    }

    public function getCreate()
    {

    }

    public function postCreate(Request $request)
    {

    }

    public function getEdit($id)
    {

    }

    public function postUpdate(Request $request, $id)
    {

    }

    public function getDelete($id)
    {

    }

}