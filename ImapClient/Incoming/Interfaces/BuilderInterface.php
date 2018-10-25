<?php

namespace sergey144010\ImapClient\Incoming\Interfaces;

use sergey144010\ImapClient\MessageIdentifierInterface;
use sergey144010\ImapClient\Incoming\Interfaces\SetIdentifierInterface;

interface BuilderInterface extends SetIdentifierInterface
{
    public function setFlag(string $flag) : void;
    public function getMessage() : MessageInterface;
}