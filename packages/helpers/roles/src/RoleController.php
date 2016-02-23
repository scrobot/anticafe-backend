<?php

namespace Helpers\Roles;

use Anticafe\Http\Controllers\Controller;
use Anticafe\Http\Models\User;
use Helpers\Permissions\Permission;
use Illuminate\Http\Request;


class RoleController extends Controller
{

	public function __construct()
	{
		$this->middleware('roles');
	}

    public function getIndex()
    {
        $roles = Role::all();

        return view('roles::list')->withRoles($roles)->withTitle("Роли");
    }

    public function getCreate()
    {
        return view('roles::create')->withTitle("Роли");
    }

    public function postStore(Request $request)
    {
        Role::create($request->all());

        return redirect(action('\Helpers\Roles\RoleController@getIndex'))->withMsg('common.msg.create');
    }

    public function getEdit($id)
    {
        $role = Role::find($id);

        return view('roles::edit')->withRole($role)->withTitle("Роли");
    }

    public function postUpdate(Request $request, $id)
    {
        $role = Role::find($id);
        $role->update($request->all());

        return redirect(action('\Helpers\RoleController@getIndex'))->withMsg("common.msg.edit");
    }

    public function getDestroy($id)
    {
        Role::destroy($id);

        return back()->withMsg('Удалено');
    }

    public function getPermissions($id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();

        return view('roles::permissions')->withRole($role)->withPermissions($permissions)->withTitle("Роли");
    }

    public function postAttachWithRole(Request $request, $id)
    {
        $role = Role::find($id);

        $role->Permissions()->sync(is_null($request->input('permissions')) ? [] : $request->input('permissions'));

        return back()->withMsg('common.msg.perms_pack');
    }

    public function getUsers($id)
    {
        $role = Role::find($id);

        $users = User::all();

        return view('roles::users')->withRole($role)->withUsers($users)->withTitle("Роли");
    }

    public function postAttachUsers(Request $request, $id)
    {
        $role = Role::find($id);

        $role->users()->sync($request->input('users'));

        return back()->withMsg('common.msg.users_pack');
    }

}