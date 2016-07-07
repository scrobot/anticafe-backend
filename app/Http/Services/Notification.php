<?php
/**
 * Created by PhpStorm.
 * User: scrobot91
 * Date: 07.07.2016
 * Time: 11:51
 */

namespace Anticafe\Http\Services;

class Notification
{
    protected $message;
    protected $devices;

    /**
     * Notification constructor.
     * @param $message
     * @param $devices
     */
    public function __construct($message, $devices)
    {
        $this->message = $message;
        $this->devices = $devices;
    }


    public function send()
    {
        $this->sendiOS();
        $this->sendAndroid();
    }
    
    private function sendiOS()
    {

        $senders = $this->getDevices('ios');

        \PushNotification::app('anticafe_ios')
            ->to($senders)
            ->send($this->message);
    }

    private function getDevices($type) {
        $devices_array = [];

        foreach ($this->devices->where('os', $type)->pluck('token') as $item) {
            $devices_array[] = \PushNotification::Device($item, ['badge' => 1]);
        }

        return \PushNotification::DeviceCollection($devices_array);
    }

    private function sendAndroid()
    {
        $senders = $this->getDevices('android');

        \PushNotification::app('anticafe_android')
            ->to($senders)
            ->send($this->message);
    }

}