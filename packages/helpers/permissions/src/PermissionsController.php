<?php

namespace Helpers\Permissions;

use Anticafe\Http\Controllers\Controller;
use Stringy\StaticStringy;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
        $permissions = Permission::all();

        return view('permissions::list')->withPermissions($permissions)->withTitle(config('module.permissions.name'));
    }

    public function getCreate()
    {
        return view('permissions::create')->withTitle(config('module.permissions.name'));
    }

    public function postStore(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->id = $request->input('slug');
        $permission->module = config('module.'.$request->input('module'));
        $permission->for_whom = $request->input('for_whom');

        $permission->save();

        return redirect(action('\Anticafe\Packages\Permissions\PermissionsController@getIndex'))->withMsg('Cоздано');
    }

    public function getEdit($id)
    {
        $permission = Permission::find($id);

        return view('permissions::edit')->withPermission($permission)->withTitle(config('module.permissions.name'));
    }

    public function postUpdate(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->id = $request->input('slug');
        $permission->module = config('module.'.$request->input('module'));
        $permission->for_whom = $request->input('for_whom');

        $permission->save();

        return redirect(action('\Anticafe\Packages\Permissions\PermissionsController@getIndex'))->withMsg('Отредактировано');
    }

    public function getDestroy($id)
    {
        Permission::destroy($id);

        return back()->withMsg('Удалено');
    }

}