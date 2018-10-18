<?php

namespace sergey144010\ImapClient\Incoming;


use sergey144010\ImapClient\Incoming\Interfaces\MessageInterface;

class Message implements MessageInterface
{
    const STRUCTURE = 'structure';
    const PARTS = 'parts';
    const HEADERS = 'headers';
    const SHORT_HEADERS = 'shortHeaders';
    const BODY = 'body';
    const WITH_OUT_ATTACHMENTS = 'withOutAttachments';
    const ATTACHMENTS = 'attachments';
    const DEFAULT = 'default';

    private $headers;
    private $body;
    private $attachments;

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param mixed $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

}