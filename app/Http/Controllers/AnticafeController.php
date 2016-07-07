<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 10.02.2016
 * Time: 15:03
 */

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Anticafe;
use Anticafe\Http\Models\Client;
use Anticafe\Http\Models\Device;
use Anticafe\Http\Models\Like;
use Anticafe\Http\Models\Tag;
use Anticafe\Http\Services\Message;
use Anticafe\Http\Services\Notification;
use Doctrine\DBAL\Query\QueryBuilder;
use Helpers\ImageHandler\ImageHandler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class AnticafeController extends Controller
{

    private $title;
    private $count;
    private $selected;

    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = Anticafe::getModelName();
        $this->count['anticafes'] = Anticafe::anticafesCount();
        $this->count['events'] = Anticafe::eventsCount();
        $this->selected = [
            "anticafe" => null,
            "client" => null
        ];
    }


    public function getIndex(Request $request)
    {
        $query = Anticafe::getAnticafes();
        $is_builder = is_a($query, Builder::class);
        if($is_builder) {
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
        }

        return view('anticafes.list')->withAnticafes($query)->withTitle($this->title)->withCount($this->count)->withIsPaginator($is_builder);

    }

    public function getShow($id)
    {
        $anticafe = Anticafe::find($id);

        return view('anticafes.show')->withAnticafe($anticafe)->withTitle($this->title)->withCount($this->count);
    }

    public function getCreate()
    {
        return view('anticafes.model')->withAnticafe(null)->withAction(action('AnticafeController@postCreate'))
                                    ->withTags(Tag::sorted()->groups()->get())
                                    ->withTitle($this->title)
                                    ->withAlones(Tag::sorted()->alones()->get())
                                    ->withCount($this->count);
    }

    public function postCreate(Request $request)
    {
        $query = Anticafe::customCreate($request);

        if(\Validator::class == class_basename($query)) {
            return back()->withErrors($query->errors())->withInput();
        }
        
        $message = new Message("Создано новое антикафе", "Посмотреть");
        (new Notification(\PushNotification::Message($message->text, $message->attrs()), Device::all()))->send();

        return redirect(action('AnticafeController@getUpdate', $query->id))->withMsg('common.msg.create');
    }

    public function getUpdate($id)
    {
        $q = Anticafe::find($id);
        return view('anticafes.model')->withAnticafe($q)
                                    ->withAction(action('AnticafeController@postUpdate', $q->id))
                                    ->withTags(Tag::sorted()->get())
                                    ->withAlones(Tag::sorted()->alones()->get())
                                    ->withTitle($this->title)
                                    ->withCount($this->count);
    }

    public function postUpdate(Request $request, $id)
    {
        $anticafe = Anticafe::find($id);

        $validator = $anticafe->customUpdate($request);

        if($validator instanceof Validator && $validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
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

        return redirect(route('anticafes'))->withMsg('common.msg.trash_cleaned');

    }

    public function getClean($id)
    {
        $anticafe = Anticafe::find($id);
        $anticafe->forceDelete();

        return back()->withMsg('common.msg.cleaned');
    }

    public function getLikes()
    {
        $likes = Like::all();

        $likes->load("Anticafe", "Client");

        return view("anticafes.likes")
            ->withLikes($likes)
            ->withTitle($this->title)
            ->withCount($this->count)
            ->withAnticafes(Anticafe::getList("name"))
            ->withClients(Client::getList("email"))
            ->withSelected($this->selected);
    }

    public function postLikesFilter(Request $request)
    {
        $likes = \DB::table('likes');
        if($request->input('anticafe') != 0) {
            $likes = $likes->where('anticafe_id', $request->input('anticafe'));
            $this->selected['anticafe'] = $request->input('anticafe');
        }

        if($request->input('client') != 0) {
            $likes = $likes->where('client_id', $request->input('client'));
            $this->selected['client'] = $request->input('client');
        }

        $likes = collect($likes->get())->pluck('id');
        $likes = Like::whereIn("id", $likes)->get();
        
        $likes->load("Anticafe", "Client");

        return view("anticafes.likes")
            ->withLikes($likes)
            ->withTitle($this->title)
            ->withCount($this->count)
            ->withAnticafes(Anticafe::getList("name"))
            ->withClients(Client::getList("email"))
            ->withSelected($this->selected);
    }
}