<?php

namespace App\Application\Services\SmartInvite\Imap;

class TypeBody extends \SSilence\ImapClient\TypeBody
{
    /**
     * @inheritdoc
     */
    private static $types = array('PLAIN', 'HTML', 'CALENDAR');

    /**
     * @inheritdoc
     */
    public static function get()
    {
        return static::$types;
    }
}