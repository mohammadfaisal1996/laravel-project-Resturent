<?php
namespace App\Traits;
use Illuminate\Support\Facades\Session;

trait Firebase{
    use ApiResponse;

    public function sendFirebaseNotification($notification, $token){


        try {
            $SERVER_API_KEY = env("FIREBASE_API_KEY");
            $data = [
                "registration_ids" => $token,
                "notification" => [
                    "title" => [
                         $notification["title"]["en"].','.$notification["title"]["ar"]
                    ],
                    "body" => [
                         $notification["body"]["en"].','.$notification["body"]["ar"]
                    ],
                ]
            ];
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            $jsonData = json_encode($data);

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

            $response = curl_exec($ch);
            
            return $response;

        } catch (\Exception $e){
            return $this->sendError("error firebase", 401,401);
        }


    }

}
