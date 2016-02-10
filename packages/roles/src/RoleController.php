<?php

namespace Anticafe\Packages\Roles;

use Anticafe\Http\Controllers\Controller;
use Anticafe\Http\Models\User;
use Anticafe\Packages\Permissions\Permission;
use Illuminate\Http\Request;


class RoleController extends Controller
{

    public function getIndex()
    {
        $roles = Role::all();

        return view('roles::list')->withRoles($roles)->withTitle(config('module.roles.name'));
    }

    public function getCreate()
    {
        return view('roles::create')->withTitle(config('module.roles.name'));
    }

    public function postStore(Request $request)
    {
        Role::create($request->all());

        return redirect(action('\Anticafe\Packages\Roles\RoleController@getIndex'))->withMsg('Создано');
    }

    public function getEdit($id)
    {
        $role = Role::find($id);

        return view('roles::edit')->withRole($role)->withTitle(config('module.roles.name'));
    }

    public function postUpdate(Request $request, $id)
    {
        $role = Role::find($id);
        $role->update($request->all());

        return redirect(action('\Anticafe\Packages\Roles\RoleController@getIndex'))->withMsg('Редактировать');
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

        return view('roles::permissions')->withRole($role)->withPermissions($permissions)->withTitle(config('module.roles.name'));
    }

    public function postAttachWithRole(Request $request, $id)
    {
        $role = Role::find($id);

        $role->permissions()->sync(is_null($request->input('permissions')) ? [] : $request->input('permissions'));

        return back()->withMsg('Набор правил отредактирован');
    }

    public function getUsers($id)
    {
        $role = Role::find($id);

        $users = User::all();

        return view('roles::users')->withRole($role)->withUsers($users)->withTitle(config('module.roles.name'));
    }

    public function postAttachUsers(Request $request, $id)
    {
        $role = Role::find($id);

        $role->users()->sync($request->input('users'));

        return back()->withMsg('Набор пользователей отредактирован');
    }

}