<?php

namespace sergey144010\ImapClient;

class AdapterForOutgoingMessage
{
    private $parameters;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Send an email. Not implemented
     *
     * @throws ImapClientException
     */
    public function send()
    {
        throw new ImapClientException('Not implemented');
    }
}
