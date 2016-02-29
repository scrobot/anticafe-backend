<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 10.02.2016
 * Time: 15:03
 */

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Anticafe;
use Anticafe\Http\Models\Tag;
use Helpers\ImageHandler\ImageHandler;
use Illuminate\Http\Request;

class AnticafeController extends Controller
{

    private $title;
    private $count;

    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = Anticafe::getModelName();
        $this->count['anticafes'] = Anticafe::anticafesCount();
        $this->count['events'] = Anticafe::eventsCount();
    }


    public function getIndex(Request $request)
    {
        $query = Anticafe::getAnticafes();
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

        return view('anticafes.list')->withAnticafes($query)->withTitle($this->title)->withCount($this->count);

    }

    public function getShow($id)
    {
        $anticafe = Anticafe::find($id);

        return view('anticafes.show')->withAnticafe($anticafe)->withTitle($this->title)->withCount($this->count);
    }

    public function getCreate()
    {
        return view('anticafes.model')->withAnticafe(null)->withAction(action('AnticafeController@postCreate'))->withTags(Tag::sorted()->get())->withAlones(Tag::sorted()->alones()->get())->withTitle($this->title)->withCount($this->count);
    }

    public function postCreate(Request $request)
    {
        $query = Anticafe::customCreate($request);

        if(\Validator::class == class_basename($query)) {
            return back()->withErrors($query->errors());
        }

        return redirect(action('AnticafeController@getUpdate', $query->id))->withMsg('common.msg.create');
    }

    public function getUpdate($id)
    {
        $q = Anticafe::find($id);
        return view('anticafes.model')->withAnticafe($q)->withAction(action('AnticafeController@postUpdate', $q->id))->withTags(Tag::sorted()->get())->withAlones(Tag::sorted()->alones()->get())->withTitle($this->title)->withCount($this->count);
    }

    public function postUpdate(Request $request, $id)
    {
        $anticafe = Anticafe::find($id);

        $validator = $anticafe->customUpdate($request);

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

    public function getTrash()
    {
        $query = Anticafe::onlyTrashed()->get();

        return view('anticafes.trash')->withAnticafes($query)->withTitle($this->title)->withCount($this->count);
    }

    public function getRestoreAll()
    {
        $anticafes = Anticafe::onlyTrashed()->get();

        foreach ($anticafes as $anticafe) {
            $anticafe->restore();
        }

        return redirect(route('anticafes'))->withMsg('common.msg.trash_restored');

    }

    public function getRestore($id)
    {
        $anticafe = Anticafe::onlyTrashed()->where("id", $id)->first();
        $anticafe->restore();

        return redirect(route('anticafes'))->withMsg('common.msg.restored');
    }

    public function getDestroy()
    {
        $anticafes = Anticafe::onlyTrashed()->get();

        foreach ($anticafes as $anticafe) {
            $anticafe->forceDelete();
        }

        return back()->withMsg('common.msg.trash_cleaned');

    }

    public function getClean($id)
    {
        $anticafe = Anticafe::find($id);
        $anticafe->forceDelete();

        return back()->withMsg('common.msg.cleaned');
    }
}