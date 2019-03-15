<?php

namespace App\Infrastructure\Imap;

class TypeAttachments extends \SSilence\ImapClient\TypeAttachments
{
    private static $types = array('ICS', 'JPEG', 'PNG', 'GIF', 'PDF', 'X-MPEG', 'MSWORD', 'OCTET-STREAM', 'TXT', 'TEXT', 'MWORD', 'ZIP', 'MPEG', 'DBASE', 'ACROBAT', 'POWERPOINT', 'BMP', 'BITMAP');

    /**
     * @inheritdoc
     */
    public static function get()
    {
        return static::$types;
    }
}