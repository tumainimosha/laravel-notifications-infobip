<?php

namespace NotificationChannels\Infobip;

use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use NotificationChannels\Infobip\Exceptions\CouldNotSendNotification;

class InfobipChannel
{
    /**
     * @var Infobip
     */
    protected $infobip;

    public function __construct(Infobip $infobip)
    {
        $this->infobip = $infobip;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return mixed
     */
    public function send($notifiable, Notification $notification)
    {
        try {
            $to = $this->getTo($notifiable);
            $message = $notification->toInfobip($notifiable);

            if (is_string($message)) {
                $message = new InfobipMessage($message);
            }
            if (!$message instanceof InfobipMessage) {
                throw CouldNotSendNotification::invalidMessageObject($message);
            }
            return $this->infobip->sendMessage($message, $to);
        } catch (\Exception $exception) {
            $event = new NotificationFailed($notifiable, $notification, 'infobip', ['message' => $exception->getMessage(), 'exception' => $exception]);
            if (function_exists('event')) { // Use event helper when possible to add Lumen support
                event($event);
            } else {
                $this->events->fire($event);
            }
        }
    }

    /**
     * Get the address to send a notification to.
     *
     * @param mixed $notifiable
     * @return mixed
     * @throws CouldNotSendNotification
     */
    protected function getTo($notifiable)
    {
        if ($notifiable->routeNotificationFor('infobip')) {
            return $notifiable->routeNotificationFor('infobip');
        }
        if (isset($notifiable->phone_number)) {
            return $notifiable->phone_number;
        }
        throw CouldNotSendNotification::invalidReceiver();
    }
}
