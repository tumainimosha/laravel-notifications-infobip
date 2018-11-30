<?php

namespace NotificationChannels\Infobip\Exceptions;

use NotificationChannels\Infobip\InfobipMessage;

class CouldNotSendNotification extends BaseException
{
    /**
     * @return CouldNotSendNotification
     */
    public static function invalidReceiver()
    {
        return new static(
            'The notifiable did not have a receiving phone number. Add a routeNotificationForInfobip
            method or a phone_number attribute to your notifiable.'
        );

    }

    /**
     * @param mixed $message
     *
     * @return CouldNotSendNotification
     */
    public static function invalidMessageObject($message)
    {
        $className = get_class($message) ?: 'Unknown';
        return new static(
            "Notification was not sent. Message object class `{$className}` is invalid. It should
            be `".InfobipMessage::class.'`');
    }

}