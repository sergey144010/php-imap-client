<?php

namespace sergey144010\ImapClient\Connect;


interface MailboxInterface
{
    public function getRemoteSystemName();
    public function getPort();
    /** @return FlagsInterface */
    public function getFlags();
    public function getMailboxName();
    public function getMailbox();
    public function getServerPart();
}