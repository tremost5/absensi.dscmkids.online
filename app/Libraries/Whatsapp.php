<?php

namespace App\Libraries;

class Whatsapp
{
    public static function send($to, $message)
    {
        $token = getenv('uxh5r7zzJ8rMCzCyYekug');

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
            CURLOPT_POSTFIELDS => [
                'target' => $to,
                'message' => $message
            ],
        ]);

        curl_exec($curl);
        curl_close($curl);
    }
}
