<?php

namespace sergey144010\ImapClient\Incoming\Interfaces;


interface MessageInterface
{
    public function getHeaders();
    #public function setHeaders($headers);
    public function getBody();
    #public function setBody($body);
    public function getAttachments();
    #public function setAttachments($attachments);
}