<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 10.02.2016
 * Time: 17:48
 */

namespace Anticafe\Http\Controllers;

use Anticafe\Http\Models\ImageOption;
use Illuminate\Http\Request;

class ImageOptionsController extends Controller
{

    private $title;

    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = ImageOption::getModelName();
        $this->middleware('options');
    }

    public function getIndex()
    {
        $options = ImageOption::all();
        return view('options.image.list')->withOptions($options)->withTitle($this->title);
    }

    public function getCreate()
    {
        return view('options.image.model')->withTitle($this->title)->withOption(null)->withAction(action('ImageOptionsController@postCreate'));
    }

    public function postCreate(Request $request)
    {
        $query = ImageOption::customCreate($request);

        if(\Validator::class == class_basename($query)) {
            return back()->withErrors($query->errors());
        }

        return redirect(action('ImageOptionsController@getUpdate', $query->id))->withMsg('common.msg.create');
    }

    public function getUpdate($id)
    {
        $option = ImageOption::find($id);
        return view('options.image.model')->withTitle($this->title)->withOption($option)->withAction(action('ImageOptionsController@postUpdate', $option->id));
    }

    public function postUpdate(Request $request, $id)
    {
        $option = ImageOption::find($id);

        $validator = $option->customUpdate($request);

        if($validator != true) {
            return back()->withErrors($validator->errors());
        }

        return back()->withMsg('common.msg.edit');
    }

    public function getDestroy($id)
    {
        ImageOption::destroy($id);
        return back()->withMsg('common.msg.delete');
    }

}