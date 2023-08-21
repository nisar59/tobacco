<?php


namespace App\Helpers;


use App\Models\Device;
use App\Models\Devices;
use App\Models\User;
use App\Models\UserDevices;
use Illuminate\Support\Facades\Http;

class PushHelper
{

    public static function curlCall($url,$headers,$body,$type)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, $type);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        /*if(curl_exec($ch) === false)
        {
            echo 'Curl error: ' . curl_error($ch);
        }*/
        $error = curl_error($ch);
        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result);
        return $result;
    }

    public static function fireBase($device_id,$message,$type=1)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = 'AAAAAT0syoQ:APA91bFb6AtPug25OGMmYB-kUHNCSKP9hGbURutekCLyWwnbvXn-7z9nYgihhCuoe4HFxs6bFjDktjjAUvMc4HbFgSJ71jMHOqjqmeVXs-pp-h8GeZXvUuGmEyqGpyhEdxTws1gD41BY';

        $body = array (
            'registration_ids' => array (
                $device_id
            ),
            'data' => array (
                "body" => $message,
                "title" => $type,
            )
        );

        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );

        return self::curlCall($url,$headers,$body,true);

    }

    public static function sendPushNotification($user_id,$message,$type,$notification_id){

        $user_devices = Device::where(['user_id' => $user_id])->get();
        foreach($user_devices as $user_device) {
            $device_id = Device::where(['id' => $user_device->device_id])->first();
            $push_id = $device_id->push_id;
            self::fireBase($push_id, $message, $type);
//            NotificationLogsHelper::notificationDevices($notification_id,$user_id,$device_id->id);
        }
    }

}
