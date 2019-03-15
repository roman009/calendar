<?php

namespace App\Infrastructure\Imap;

use SSilence\ImapClient\ImapClientException;

class IncomingMessage extends \SSilence\ImapClient\IncomingMessage
{
    /**
     * @inheritdoc
     */
    protected function getSections($type = null)
    {
        if (!$type) {
            return $this->section;
        }
        $types = null;
        switch ($type) {
            case self::SECTION_ATTACHMENTS:
                $types = TypeAttachments::get();
                break;
            case self::SECTION_BODY:
                $types = TypeBody::get();
                break;
            default:
                throw new ImapClientException('Section type not recognised/supported');
                break;
        }
        $sections = [];
        foreach ($this->section as $section) {
            $obj = $this->getSectionStructure($section);
            if (!isset($obj->subtype)) {
                continue;
            }
            if (in_array($obj->subtype, $types, false)) {
                $sections[] = $section;
            }
        }

        return $sections;
    }
}
