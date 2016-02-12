<?php

namespace Anticafe\Http\Controllers;

use Anticafe\Http\Models\Anticafe;
use Anticafe\Http\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    private $title;

    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = Event::getModelName();
    }

    public function getIndex()
    {
        $query = Event::paginate(15);

        return view('events.list')->withEvents($query)->withTitle($this->title);
    }

    public function getCreate()
    {
        return view('events.model')->withEvent(null)->withAnticafes(Anticafe::where('id', '!=', 0)->orderBy('name')->get())->withAction(action('EventsController@postCreate'))->withTitle($this->title);
    }

    public function postCreate(Request $request)
    {
        $query = Event::createOrUpdate($request);

        if(\Validator::class == class_basename($query)) {
            return back()->withErrors($query->errors());
        }

        return redirect(action('EventsController@getUpdate', $query->id))->withMsg('common.msg.create');
    }

    public function getUpdate($id)
    {
        return view('events.model')->withEvent(Event::find($id))->withAnticafes(Anticafe::all())->withAction(action('EventsController@postUpdate', $id))->withTitle($this->title);
    }

    public function postUpdate(Request $request, $id)
    {
        $query = Event::createOrUpdate($request, $id);

        if(\Validator::class == class_basename($query)) {
            return back()->withErrors($query->errors());
        }

        return back()->withMsg('common.msg.edit');
    }

    public function getDestroy($id)
    {
        Event::destroy($id);
        return back()->withMsg('common.msg.delete');
    }

}