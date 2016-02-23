<?php

namespace Helpers\Permissions;

use Anticafe\Http\Controllers\Controller;
use Stringy\StaticStringy;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{

	public function __construct()
	{
		$this->middleware('perms');
	}

    public function getIndex()
    {
        $permissions = Permission::all();

        return view('permissions::list')->withPermissions($permissions)->withTitle("Правила");
    }

    public function getCreate()
    {
        return view('permissions::create')->withTitle("Правила");
    }

    public function postStore(Request $request)
    {
        $permission = new Permission();
        $permission->name = $request->input('name');
        $permission->id = $request->input('slug');
        $permission->group = $request->input('module');

        $permission->save();

        return redirect(action('\Helpers\Permissions\PermissionsController@getIndex'))->withMsg('common.msg.create');
    }

    public function getEdit($id)
    {
        $permission = Permission::find($id);

        return view('permissions::edit')->withPermission($permission)->withTitle("Правила");
    }

    public function postUpdate(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->id = $request->input('slug');
        $permission->group = $request->input('module');

        $permission->save();

        return redirect(action('\Helpers\Permissions\PermissionsController@getIndex'))->withMsg('common.msg.edit');
    }

    public function getDestroy($id)
    {
        Permission::destroy($id);

        return back()->withMsg('common.msg.delete');
    }

}