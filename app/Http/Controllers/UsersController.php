<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 10.02.2016
 * Time: 12:41
 */

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Anticafe;
use Anticafe\Http\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function getIndex()
    {
        check_perm('users.see');

        $users = User::paginate(15);

        return view('users.list')->withUsers($users)->withTitle(User::getModelName());
    }

    public function getCreate()
    {
        check_perm('users.create');
        return view('users.create')->withTitle(User::getModelName())->withAnticafes(Anticafe::where('id', ">", 0)->orderBy('type', 'asc')->get());
    }

    public function postCreate(Request $request)
    {
        $user = new User();
        $valid = $user->validator($request->all());
        if($valid->fails()) {
            return back()->withErrors($valid->errors());
        }

        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $user->Roles()->sync($request->input('roles'));
        $user->Entities()->sync($request->input('anticafes') == null ? [] : $request->input('anticafes'));

        return redirect(route('users'))->withMsg('common.msg.create');
    }

    public function getEdit($id)
    {
        $user = User::find($id);
        check_perm(['users.edit', 'users.edit.self'], ['Anticafe\Http\Models\User@isMe', $user], null, 'or');
        return view('users.edit')->withUser($user)->withTitle(User::getModelName())->withAnticafes(Anticafe::ordered()->get());
    }

    public function postUpdate(Request $request, $id)
    {

        if($request->has('password')) {
            $r = $request->all();
            $r['password'] = bcrypt($r['password']);
        } else {
            $r = $request->except('password', 'password_confirmation');
        }

        $user = User::find($id);
        $user->update($r);

        if(can("users.edit")) {
            $user->Roles()->sync($request->input('roles'));
            $user->Entities()->sync($request->input('anticafes') == null ? [] : $request->input('anticafes'));
        }

        return back()->withMsg('common.msg.edit');

    }

    public function getDestroy($id)
    {
        check_perm('users.delete');
        User::find($id)->delete();
        return back()->withMsg('common.msg.delete');
    }

    public function getBlock($id)
    {
        check_perm('users.block');
        $user = User::find($id);
        $user->blocked = 1;
        $user->save();
        return back()->withMsg('common.msg.blocked');
    }

    public function getUnblock($id)
    {
        check_perm('users.unblock');
        $user = User::find($id);
        $user->blocked = 0;
        $user->save();
        return back()->withMsg('common.msg.unblocked');
    }


}