<?php

namespace App\Infrastructure\Imap;

class TypeBody extends \SSilence\ImapClient\TypeBody
{
    /**
     * @inheritdoc
     */
    private static $types = ['PLAIN', 'HTML', 'CALENDAR'];

    /**
     * @inheritdoc
     */
    public static function get()
    {
        return static::$types;
    }
}
