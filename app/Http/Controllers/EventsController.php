<?php

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Anticafe;
use Anticafe\Http\Models\Tag;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    private $title;
    private $count;

    /**
     * EventsController constructor.
     */
    public function __construct()
    {
        $this->title = "События";
        $this->count['anticafes'] = Anticafe::anticafesCount();
        $this->count['events'] = Anticafe::eventsCount();
    }

    public function getIndex(Request $request)
    {
        $query = Anticafe::getEvents();
        if($request->get('name')) {
            $query = $query->orderBy('name', $request->get('name'))->paginate(15);
        } elseif($request->get('total_views')) {
            $query = $query->orderBy('total_views', $request->get('total_views'))->paginate(15);
        } elseif($request->get('total_likes')) {
            $query = $query->orderBy('total_likes', $request->get('total_likes'))->paginate(15);
        } elseif($request->get('total_bookings')) {
            $query = $query->orderBy('total_bookings', $request->get('total_bookings'))->paginate(15);
        } else {
            $query = $query->paginate(15);
        }

        return view('events.list')->withEvents($query)->withTitle($this->title)->withCount($this->count);
    }

    public function getCreate()
    {
        return view('events.model')->withEvent(null)->withAction(action('EventsController@postCreate'))->withAnticafes(Anticafe::getAnticafes()->get())->withTags(Tag::sorted()->groups()->get())->withAlones(Tag::sorted()->alones()->get())->withTitle($this->title)->withCount($this->count);
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
        return view('events.model')->withEvent($q)->withAction(action('EventsController@postUpdate', $q->id))->withAnticafes(Anticafe::getAnticafes()->get())->withTags(Tag::sorted()->groups()->get())->withAlones(Tag::sorted()->alones()->get())->withTitle($this->title)->withCount($this->count);
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