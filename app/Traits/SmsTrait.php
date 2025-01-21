<?php

namespace App\Traits;

use TaqnyatSms;

trait SmsTrait
{
    public function sendVerificationCode($to, $code)
    {
        $setting = setting();
        // Sending a SMS using Taqnyat API and PHP is easy as the following:
        $bearer = $setting->sms_token;
        $sender = $setting->sms_sender;
        $taqnyt = new TaqnyatSms($bearer);

        $body   = 'رمز التحقق لـ ' . setting()->name . ' هو: ' . $code;

        $recipients = $to;
        $taqnyt->sendMsg($body, $recipients, $sender);
    }

    public function sendSms($to, $message)
    {
        $setting = setting();
        // Sending a SMS using Taqnyat API and PHP is easy as the following:
        $bearer = $setting->sms_token;
        $sender = $setting->sms_sender;
        $taqnyt = new TaqnyatSms($bearer);

        $body       = $message;
        $recipients = $to;

        $taqnyt->sendMsg($body, $recipients, $sender);
    }

    public function giftConfirmationSms($to, $message)
    {
        $setting = setting();
        // Sending a SMS using Taqnyat API and PHP is easy as the following:
        $bearer = $setting->sms_token;
        $sender = $setting->sms_sender;
        $taqnyt = new TaqnyatSms($bearer);

        $body       = $message;
        $recipients = $to;

        $taqnyt->sendMsg($body, $recipients, $sender);
    }
}
