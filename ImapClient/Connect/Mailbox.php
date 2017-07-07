<?php

namespace sergey144010\ImapClient\Connect;

use sergey144010\ImapClient\Connect\Interfaces\MailboxInterface;
use sergey144010\ImapClient\Connect\Interfaces\FlagsInterface;

class Mailbox implements MailboxInterface
{
    private $remote_system_name;
    private $port;
    private $flags;
    private $mailbox_name;

    public function __construct(
        $remote_system_name,
        $port = null,
        FlagsInterface $flags = null,
        $mailbox_name = null
    )
    {
        $this->remote_system_name = $remote_system_name;
        $this->port = $port;
        $this->flags = $flags;
        $this->mailbox_name = $mailbox_name;
    }

    public function getRemoteSystemName()
    {
        return $this->remote_system_name;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getFlags()
    {
        return $this->flags;
    }

    public function getMailboxName()
    {
        return $this->mailbox_name;
    }

    public function getMailbox()
    {
        return $this->getServerPart().$this->mailbox_name;
    }

    public function getServerPart()
    {
        $port = null;
        if(isset($this->port)){
            $port = ':'.$this->port;
        };
        $flags = null;
        if(isset($this->flags)){
            $flags = $this->flags->getFlags();
        };
        return '{'.$this->remote_system_name.$port.$flags.'}';
    }
}