<?php

namespace sergey144010\ImapClient;

use sergey144010\ImapClient\Connect\ImapConnect as Connect;
use sergey144010\ImapClient\Connect\Mailbox;
use sergey144010\ImapClient\Connect\Parameters;

class ImapClientSimple
{
    private function __construct()
    {
    }

    public static function connect($server, $user, $pass, $port = null, $mailBox = null, $flags = null)
    {
        $parameters = new Parameters(
            new Mailbox(
                $server,
                $port,
                $flags,
                $mailBox
            ),
            $user,
            $pass
        );
        return new ImapClient(new Connect($parameters));
    }
}