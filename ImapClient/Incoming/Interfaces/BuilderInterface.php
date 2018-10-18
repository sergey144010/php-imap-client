<?php

namespace sergey144010\ImapClient\Incoming\Interfaces;

use sergey144010\ImapClient\MessageIdentifierInterface;

interface BuilderInterface
{
    public function setFlag(string $flag) : void;
    public function getMessage( MessageIdentifierInterface $messageIdentifier ) : MessageInterface;
}