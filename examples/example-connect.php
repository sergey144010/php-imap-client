<?php

namespace program;

require_once "vendor/autoload.php";

use sergey144010\ImapClient\ImapClientException;
/* For Simple connect */
use sergey144010\ImapClient\ImapClientSimple;
/* For Advanced connect */
use sergey144010\ImapClient\Connect\Flags;
use sergey144010\ImapClient\Connect\Mailbox;
use sergey144010\ImapClient\Connect\Parameters;
use sergey144010\ImapClient\Connect\ImapConnect;
use sergey144010\ImapClient\ImapClient;

try{
    /* For Simple connect */
    $imapClient = ImapClientSimple::connect('imap.server.com', 'user@server.com', 'password');

    /* For Advanced connect */
    $flags = new Flags(Flags::NOVALIDATE_CERT);
    $mailbox = new Mailbox('imap.server.com', $port = 143, $flags, 'INBOX/TestForImapClient');
    $parameters = new Parameters($mailbox, 'user@server.com', 'password');

    $imapClient = new ImapClient(new ImapConnect($parameters));

    /* future code here */

}catch (ImapClientException $error){
    echo $error->getMessage().PHP_EOL;
}