<?php

namespace sergey144010\ImapClient\Connect;

use \Exception;
use sergey144010\ImapClient\ImapClientException;


class ImapConnect implements ImapConnectInterface
{
    /**
     * @var resource
     */
    private $stream;
    private $parameters;

    public function __construct(ParametersInterface $parameters)
    {
        $this->parameters = $parameters;
        $this->connect();
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    private function connect()
    {
        if (!function_exists('imap_open')) {
            throw new Exception('Imap function not available.');
        };
        $this->stream = @imap_open(
            $this->parameters->getMailboxString(),
            $this->parameters->getUsername(),
            $this->parameters->getPassword(),
            $this->parameters->getOptions(),
            $this->parameters->getNRetries(),
            $this->parameters->getParams()
        );
        if ($this->stream === false) {
            throw new ImapClientException('Error connecting to '.$this->parameters->getMailbox()->getRemoteSystemName());
        };
    }

}