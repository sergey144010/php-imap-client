<?php

namespace sergey144010\ImapClient\IncomingMessage;


class TypeAttachments
{
	/**
	 * Types of attachments
     *
     * @var array
	 */
    private static $types = ['JPEG', 'PNG', 'GIF', 'PDF', 'X-MPEG', 'MSWORD', 'OCTET-STREAM'];

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
