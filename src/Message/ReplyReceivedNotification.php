<?php

namespace App\Message;

class ReplyReceivedNotification
{
    /**
     * @var int
     */
    private $smartReplyId;

    public function __construct(int $smartReplyId)
    {
        $this->smartReplyId = $smartReplyId;
    }

    /**
     * @return int
     */
    public function getSmartReplyId(): int
    {
        return $this->smartReplyId;
    }
}