<?php

namespace App\Services\Notifications;

use Carbon\Carbon;

class PushNotificationService
{
    public function execute($data, $token)
    {

        $message = $data['title'];
        $date = Carbon::now();
        $header = [
            'Authorization: key= AAAAZ3ZrAcE:APA91bFonoDQW__pkxUiPynIyh4cVDRNTCEMYM_PLup_5hDV2KC6exmSeVm1GR1FKr9W8XG8-X8usF8I7tI0EX-ukFoCbvYINBMhLnalth0VBS5NLfHn89qX4o4Xpo2YT5h1URU0GHgl',
            'Content-Type: Application/json',
        ];
        $notification = [
            'title' => 'Honour The Brave',
            'body' => $message,
            'icon' => '',
            'image' => '',
            'sound' => 'default',
            'date' => $date->diffForHumans(),
            'content_available' => true,
            'priority' => 'high',
            'badge' => 0,
        ];
        if (gettype($token) == 'array') {
            $payload = [
                'registration_ids' => $token,
                'data' => (object) $data,
                'notification' => (object) $notification,
            ];
        } else {
            $payload = [
                'to' => $token,
                'data' => (object) $data,
                'notification' => (object) $notification,
            ];
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $header,
        ]);
        // return true;
        $response = curl_exec($curl);
        $d = ['res' => $response, 'data' => $data];
       
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo 'cURL Error #:'.$err;
        } else {
            return $response;
        }
    }
}
