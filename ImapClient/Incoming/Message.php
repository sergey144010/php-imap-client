<?php

namespace sergey144010\ImapClient\Incoming;


use sergey144010\ImapClient\Incoming\Interfaces\MessageInterface;
use sergey144010\ImapClient\Incoming\Interfaces\MessageStructureInterface;

class Message extends MessageStructure implements MessageInterface, MessageStructureInterface
{
    const STRUCTURE = 'structure';
    const PARTS = 'parts';
    const SHORT_HEADERS = 'shortHeaders';

    const HEADERS = 'headers';
    const BODY = 'body';
    const ATTACHMENTS = 'attachments';

    const WITH_OUT_ATTACHMENTS = 'withOutAttachments';
    const DEFAULT = 'default'; // change name

    private $headers;
    private $body;
    private $attachments;

    # Какие типы, объкты ?
    public function __construct($headers = null, $body = null, $attachments = null)
    {
        $this->headers = $headers;
        $this->body = $body;
        $this->attachments = $attachments;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

}