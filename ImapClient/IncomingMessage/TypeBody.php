<?php

namespace sergey144010\ImapClient\IncomingMessage;


class TypeBody
{
	/**
	 * Types of body's
     *
     * @var array
	 */
    private static $types = ['PLAIN', 'HTML'];

    /**
     * Get the allowed types.
     *
     * @return array
     */
    public static function get()
    {
        return static::$types;
    }
}
