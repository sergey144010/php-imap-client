<?php

namespace sergey144010\ImapClient\Connect;

use \Exception;
use sergey144010\ImapClient\Connect\Interfaces\ParametersInterface;
use sergey144010\ImapClient\Connect\Interfaces\MailboxInterface;

class Parameters implements ParametersInterface
{
    private $mailbox;
    private $username;
    private $password;
    private $options;
    private $n_retries;
    private $params;

    public function __construct(
        MailboxInterface $mailbox,
        $username,
        $password,
        $options = 0,
        $n_retries = 0,
        $params = []
    )
    {
        $this->mailbox = $mailbox;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
        $this->n_retries = $n_retries;
        $this->params = $params;
        $this->check();
    }

    private function check()
    {
        if(!isset($this->mailbox) || !isset($this->username) || !isset($this->password)){
            throw new Exception('Mailbox, Username, Password must be installed.');
        };
        if(!is_integer($this->options) || !is_integer($this->n_retries)){
            throw new Exception('Options, N_retries must be an integer.');
        };
        if(isset($this->params) && !is_array($this->params)){
            throw new Exception('Params must be an array.');
        };
    }

    public function getMailbox()
    {
        return $this->mailbox;
    }

    public function getMailboxString()
    {
        return $this->mailbox->getMailbox();
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getNRetries()
    {
        return $this->n_retries;
    }

    public function getParams()
    {
        return $this->params;
    }
}