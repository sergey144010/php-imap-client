<?php
/**
 * Created by PhpStorm.
 * User: Sergey144010
 * Date: 25.04.2017
 * Time: 0:55
 */

namespace sergey144010\ImapClient\Tests;


interface MessageInterface
{
    public function send($stream, $folder);
}