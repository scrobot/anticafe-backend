<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 10.02.2016
 * Time: 15:03
 */

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Anticafe;
use Helpers\ImageHandler\ImageHandler;
use Illuminate\Http\Request;

class AnticafeController extends Controller
{

    private $title;

    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = Anticafe::getModelName();
    }


    public function getIndex()
    {
        $query = Anticafe::paginate(15);

        return view('anticafes.list')->withAnticafes($query)->withTitle($this->title);

    }

    public function getShow($id)
    {
        $anticafe = Anticafe::find($id);

        return view('anticafes.show')->withAnticafe($anticafe)->withTitle($this->title);
    }

    public function getCreate()
    {
        return view('anticafes.create')->withTitle($this->title);
    }

    public function postCreate(Request $request)
    {
        $query = Anticafe::customCreate($request);

        if(\Validator::class == class_basename($query)) {
            return back()->withErrors($query->errors());
        }

        return redirect(action('AnticafeController@getCreateStepTwo', $query->id))->withMsg('common.msg.create');
    }

    public function getCreateStepTwo($id)
    {
        $q = Anticafe::find($id);
        return view('anticafes.create-step-2')->withAnticafe($q)->withTitle($this->title);
    }

    public function getUpdate($id)
    {
        $q = Anticafe::find($id);
        return view('anticafes.update')->withAnticafe($q)->withTitle($this->title);
    }

    public function postUpdate(Request $request, $id, $step = null)
    {
        $anticafe = Anticafe::find($id);

        $validator = $anticafe->customUpdate($request, $step);

        if($validator != true) {
            return back()->withErrors($validator->errors());
        }

        if($step != null) {
            return redirect(action('AnticafeController@getUpdate', $anticafe->id))->withMsg('common.msg.create');
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

        return view('anticafes.trash')->withAnticafes($query)->withTitle($this->title);
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
        $anticafe = Anticafe::find($id);
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