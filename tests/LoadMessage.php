<?php

namespace sergey144010\ImapClient\Tests;


class LoadMessage extends Message
{
    public function __construct()
    {
        $this->loadFile();
    }

    public function loadFile()
    {
        $this->body = file_get_contents('emails/one.eml');
    }
}