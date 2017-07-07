<?php

namespace sergey144010\ImapClient;


interface MessageIdentifierInterface
{
    public function getStream();
    public function getId();
    public function getIdentifier();
}