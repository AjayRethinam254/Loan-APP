<?php

namespace App\Utils;

use Exception;

class SMSHelper
{
    public static function sendSMS($message, $phone, $otp, $template_id)
    {
        try {
            $userName = env('MESSAGEBIRD_USER_NAME');
            $apiKey   = env('MESSAGEBIRD_API_KEY');
            $sender   = env('MESSAGEBIRD_SENDERID');
            $route    = 'TRANS';
            $format   = 'JSON';

            $postData = [
                'username'   => $userName,
                'apikey'     => $apiKey,
                'apirequest' => 'Text',
                'sender'     => $sender,
                'mobile'     => $phone,
                'message'    => $message,
                'route'      => $route,
                'TemplateID' => $template_id,
                'format'     => $format,
            ];

            $url = 'https://smsbirds.in/sms-panel/api/http/index.php?' . http_build_query($postData);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

            $result = curl_exec($ch);

            if (curl_errno($ch)) {
                $error = curl_error($ch);
                curl_close($ch);
                return [
                    'success' => false,
                    'message' => "cURL Error: $error",
                ];
            }

            curl_close($ch);

            $decoded = json_decode($result, true);

            return [
                'success'  => true,
                'message'  => 'SMS sent successfully',
                'response' => $decoded,
                'phone'    => $phone
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ];
        }
    }
}
