<?php

namespace sergey144010\ImapClient\Connect\Interfaces;


interface ParametersInterface
{
    /** @return MailboxInterface */
    public function getMailbox();
    public function getMailboxString();
    public function getUsername();
    public function getPassword();
    public function getOptions();
    public function getNRetries();
    public function getParams();
}