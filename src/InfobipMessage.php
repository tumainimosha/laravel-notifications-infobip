<?php

namespace NotificationChannels\Infobip;

class InfobipMessage
{
    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $from;

    /**
     * Create a new message instance.
     *
     * @param  string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param  string $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Set the phone number the message should be sent from.
     *
     * @param  string $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;
        return $this;
    }
}