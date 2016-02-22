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
        $groups = [];
        $groups[null] = "Выберите группу";

        foreach (Tag::groups()->get() as $group) {
            $groups[$group->id] = $group->name;
        }

        return view('tags.list')->withTitle($this->title)->withTags($tags)->withGroups($groups);
    }

    public function postStore(Request $request)
    {
        Tag::create(
            [
                'slug' => $request->input('name'),
                'name' => $request->input('name'),
                'parent_id' => $request->input('parent_id') ? $request->input('parent_id') : NULL,
                'is_group' => $request->input('is_group') ? 1 : 0
            ]
        );

        return back()->withMsg('common.msg.create');
    }

    public function getEdit($id)
    {
        $tag = Tag::find($id);
        $groups = [];
        $groups[null] = "Выберите группу";

        foreach (Tag::groups()->get() as $group) {
            $groups[$group->id] = $group->name;
        }
        return view('tags.edit')->withTitle($this->title)->withTag($tag)->withGroups($groups);
    }

    public function postUpdate(Request $request, $id)
    {
        $tag = Tag::find($id);

        $tag->update([
            'slug' => $request->input('name'),
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id') ? $request->input('parent_id') : NULL,
            'is_group' => $request->input('is_group') ? 1 : 0
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