<?php
/**
 * Created by PhpStorm.
 * User: Sergey144010
 * Date: 25.04.2017
 * Time: 0:48
 */

namespace sergey144010\ImapClient\Tests;

use sergey144010\ImapClient\Tests\MessageInterface;

class MessagesPool
{
    protected static $objects = array();

    public static function push(MessageInterface $object)
    {
        self::$objects[] = $object;
    }

    public static function clean()
    {
        self::$objects = [];
    }

    public static function send($stream, $folder)
    {
        /**
         * @var MessageInterface $object
         */
        foreach (self::$objects as $object) {
            $object->send($stream, $folder);
        }
    }
}