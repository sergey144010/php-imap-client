<?php

namespace sergey144010\ImapClient\Incoming\Interfaces;


interface BuilderInterface
{
    public function setFlag(string $flag) : void;
    public function getMessage() : MessageInterface;
}