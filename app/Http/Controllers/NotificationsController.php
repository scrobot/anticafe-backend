<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 07.07.2016
 * Time: 11:05
 */

namespace Anticafe\Http\Controllers;


use Anticafe\Http\Models\Anticafe;
use Anticafe\Http\Models\Device;
use Anticafe\Http\Models\Like;
use Anticafe\Http\Services\Message;
use Anticafe\Http\Services\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{

    public function getIndex()
    {
        return view('notifications.form')->withAnticafes(Anticafe::ordered()->get());
    }

    public function postNotify(Request $request)
    {
        $q = array_unique((Like::whereIn("anticafe_id", $request->input("anticafes"))->get()->pluck('client_id')->toArray()));
        $devices = Device::whereIn('client_id', $q)->get();
        $message = new Message($request->input('content'), $request->input('title'));

        (new Notification(\PushNotification::Message($message->text, $message->attrs()), $devices))->send();
        
        return back()->withMsg('common.msg.success');
    }
}