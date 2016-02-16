<?php

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Anticafe;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    private $title;

    /**
     * EventsController constructor.
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
        return view('events.model')->withEvent(null)->withAction(action('EventsController@postCreate'))->withAnticafes(Anticafe::getAnticafes()->get())->withTitle($this->title);
    }

    public function postCreate(Request $request)
    {
        $query = Anticafe::customCreate($request, true);

        if(\Validator::class == class_basename($query)) {
            return back()->withErrors($query->errors());
        }

        return redirect(action('EventsController@getEdit', $query->id))->withMsg('common.msg.create');
    }

    public function getEdit($id)
    {
        $q = Anticafe::find($id);
        return view('events.model')->withEvent($q)->withAction(action('EventsController@postUpdate', $q->id))->withAnticafes(Anticafe::getAnticafes()->get())->withTitle($this->title);
    }

    public function postUpdate(Request $request, $id)
    {
        $event = Anticafe::find($id);

        $validator = $event->customUpdate($request, true);

        if($validator != true) {
            return back()->withErrors($validator->errors());
        }

        return back()->withMsg('common.msg.edit');
    }

    public function getDelete($id)
    {
        $q = Anticafe::find($id);
        $q->delete();
        return back()->withMsg('common.msg.delete');
    }

}