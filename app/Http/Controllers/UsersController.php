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
        $users = User::paginate(15);

        return view('users.list')->withUsers($users)->withTitle(User::getModelName());
    }

    public function getCreate()
    {
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
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $user->Roles()->sync($request->input('roles'));
        $user->Entities()->sync($request->input('anticafes'));

        return redirect(route('users'))->withMsg('common.msg.create');
    }

    public function getEdit($id)
    {
        return view('users.edit')->withUser(User::find($id))->withTitle(User::getModelName())->withAnticafes(Anticafe::where('id', ">", 0)->orderBy('type', 'asc')->get());
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

        $user->Roles()->sync($request->input('roles'));
        $user->Entities()->sync($request->input('anticafes'));

        return back()->withMsg('common.msg.edit');

    }

    public function getDestroy($id)
    {
        User::find($id)->delete();
        return back()->withMsg('common.msg.delete');
    }

    public function getBlock($id)
    {
        $user = User::find($id);
        $user->blocked = 1;
        $user->save();
        return back()->withMsg('common.msg.blocked');
    }

    public function getUnblock($id)
    {
        $user = User::find($id);
        $user->blocked = 0;
        $user->save();
        return back()->withMsg('common.msg.unblocked');
    }


}