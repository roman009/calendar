<?php

namespace App\Infrastructure\Imap;

use SSilence\ImapClient\ImapClientException;

class ImapClient extends \SSilence\ImapClient\ImapClient
{
    /**
     * @inheritdoc
     */
    public function getMessage($id, $decode = IncomingMessage::DECODE)
    {
        $this->checkMessageId($id);
        $this->incomingMessage = new IncomingMessage($this->imap, $id, $decode);
        return $this->incomingMessage;
    }

    /**
     * @inheritdoc
     */
    private function checkMessageId($id)
    {
        if (!is_int($id)) {
            throw new ImapClientException('$id must be an integer!');
        }
        if ($id <= 0) {
            throw new ImapClientException('$id must be greater then 0!');
        }
        if ($id > $this->countMessages()) {
            throw new ImapClientException('$id does not exist');
        }
    }
}
