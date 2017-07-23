<?php
/**
 * Created by PhpStorm.
 * User: Sergey144010
 * Date: 25.04.2017
 * Time: 1:25
 */

namespace sergey144010\ImapClient\Tests;


class SimpleMessage extends Message
{
    public function __construct()
    {
        $this->body =
            "From: meS@example.com\r\n"
            ."To: youS@example.com\r\n"
            ."Subject: Plain message\r\n"
            ."\r\n"
            ."Text plain message\r\n";
    }
}