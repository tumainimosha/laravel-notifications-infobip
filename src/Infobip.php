<?php

namespace NotificationChannels\Infobip;

use infobip\api\configuration\BasicAuthConfiguration as AuthConfig;
use infobip\api\client\SendSingleTextualSms as Sms;
use infobip\api\model\sms\mt\send\textual\SMSTextualRequest as SmsRequest;

class Infobip
{
    public $client;

    public function __construct()
    {
        $auth = new AuthConfig(
            config('services.infobip.username'),
            config('services.infobip.password'),
            config('services.infobip.baseUrl')
        );

        $this->client = new Sms($auth);
    }

    public function sendMessage(InfobipMessage $message, string $to)
    {
        $smsRequest = new SmsRequest();
        $smsRequest->setFrom($message->from ?? config('services.infobip.from'));
        $smsRequest->setTo($to);
        $smsRequest->setText($message->content);

        return $this->client->execute($smsRequest);
    }
}
