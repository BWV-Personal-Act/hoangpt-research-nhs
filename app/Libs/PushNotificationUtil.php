<?php

namespace App\Libs;

use Exception;

class PushNotificationUtil
{
    public const API_URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Send push notification
     *
     * @param array $deviceTokens
     * @param array $info
     * @param array $data
     * @return bool
     */
    public static function send($deviceTokens = [], $info, $data = []) {
        $curl = curl_init();
        $url = self::API_URL;

        $fcmServerKey = config('nhs_ihs.fcm_server_key');
        if (empty($fcmServerKey)) {
            throw new Exception('FCM_SERVER_KEY env is not defined.');
        }

        $headers = [];
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $fcmServerKey;

        $body = [
            'registration_ids' => $deviceTokens,
        ];
        if ($info != null) {
            $body['notification'] = $info;
        }
        if (! empty($data)) {
            $body['data'] = $data;
        }
        $payload = json_encode($body);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // curl_execの結果を文字列で返す
        // curl_setopt($curl, CURLOPT_TIMEOUT, APNS::TIMEOUT_SECOND);

        $result = curl_exec($curl);
        curl_close($curl);
        if ($result == false) {
            return false;
        }
        $result = json_decode($result, true);
        $success = 0;
        if (isset($result['success'])) {
            $success = $result['success'];
        } elseif (isset($result['message_id'])) {
            $success = 1;
        }

        return $success == 1;
    }
}
