<?php

namespace App\Infrastructure\Imap;

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