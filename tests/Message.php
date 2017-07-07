<?php
/**
 * Created by PhpStorm.
 * User: Sergey144010
 * Date: 25.04.2017
 * Time: 1:01
 */

namespace sergey144010\ImapClient\Tests;


use sergey144010\ImapClient\Tests\MessageInterface;
use sergey144010\ImapClient\ImapClientException;


class Message implements MessageInterface
{
    public $body;

    public function send($stream, $folder)
    {
        $status = imap_append($stream, $folder, $this->body);
        if(!$status){
            throw new ImapClientException('Test message not send in test folder. imap_append() failed');
        };
        return true;
    }
}