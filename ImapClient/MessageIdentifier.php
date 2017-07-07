<?php

namespace sergey144010\ImapClient;


class MessageIdentifier implements MessageIdentifierInterface
{
    private $stream;
    private $id;
    private $identifier;

    public function __construct($stream, $id, $identifier)
    {
        $this->stream = $stream;
        $this->id = $id;
        $this->identifier = $identifier;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }
}