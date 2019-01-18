<?php

namespace sergey144010\ImapClient\Incoming\Interfaces;

use sergey144010\ImapClient\MessageIdentifierInterface;

interface SetIdentifierInterface
{
    public function setIdentifier(MessageIdentifierInterface $identifier) : void;
}