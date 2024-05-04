<?php

use App\Models\Settings;
use App\Models\User;

function send_notification($user, $title, $body, $type)
{
    // $token = $user->token;


    $SERVER_API_KEY = 'AAAAwG-Z0lQ:APA91bGlWG4ws_iGOwGYDlIlTqZE1rrMRFGtyH9EbN16FxJb0DtZ1bOrEY-q-tt-krukfNj6UJzAWaMh8tfnpOZ4RRJxETQ_WRjvucvBdgE1sautqroU4_Q7WL9W74hjQIDjXNz1BIuW';

    // $token_1 = "dX-dmPoqQ6-ub_0Q60cj-B:APA91bHEpa1BGH60wYfA_nSgV8KDQdn4oI_QLcwbNwboe7GyuTNjYWKSqk9df5NlXq4CBENj4nRdxUa-q6DksJD2iaXwQcwnGEBxoz57P0I1UKj4P5Ooc5CiYMxtyyP9YLcvdEA3Lc7e";
    $token_1 = $user->token;

    $data = [

        "registration_ids" => [
            $token_1
        ],

        "notification" => [

            "title" => $title,

            "body" =>$body,

            "sound"=> "default" // required for sound on ios

        ],

    ];

    $dataString = json_encode($data);

    $headers = [

        'Authorization: key=' . $SERVER_API_KEY,

        'Content-Type: application/json',

    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);
}
