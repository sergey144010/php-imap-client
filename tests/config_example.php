<?php

use sergey144010\ImapClient\Connect\Flags;
use sergey144010\ImapClient\Connect\Mailbox;
use sergey144010\ImapClient\Connect\Parameters;

$flags = new Flags(Flags::NOVALIDATE_CERT);
$mailbox = new Mailbox('imap.server.com', 143, $flags, 'INBOX');
$parameters = new Parameters($mailbox, 'username', 'password');