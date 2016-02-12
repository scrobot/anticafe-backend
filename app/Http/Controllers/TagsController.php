<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 12.02.2016
 * Time: 18:10
 */

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{

    private $title;

    /**
     * AnticafeController constructor.
     */
    public function __construct()
    {
        $this->title = Tag::getModelName();
    }

    public function getIndex()
    {
        $tags = Tag::sorted()->get();
        return view('tags.list')->withTitle($this->title)->withTags($tags);
    }

    public function postStore(Request $request)
    {
        Tag::create(
            [
                'id' => $request->input('name'),
                'name' => $request->input('name'),
            ]
        );

        return back()->withMsg('common.msg.create');
    }

    public function getEdit($id)
    {
        $tag = Tag::find($id);
        return view('tags.edit')->withTitle($this->title)->withTag($tag);
    }

    public function postUpdate(Request $request, $id)
    {
        $tag = Tag::find($id);

        $tag->update([
            'id' => $request->input('name'),
            'name' => $request->input('name'),
        ]);

        $tag->syncWithAliases($request->input('aliases'));

        return back()->withMsg('common.msg.update');
    }

    public function getDelete($id)
    {
        Tag::destroy($id);
        return back()->withMsg('common.msg.delete');
    }
}