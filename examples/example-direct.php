<?php

namespace program;

require_once "autoload.php";

use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\ImapClientSimple;

try{
    $imapClient = ImapClientSimple::connect('imap.server.com', 'user@server.com', 'password');

    /* future code here */

}catch (ImapClientException $error){
    echo $error->getMessage().PHP_EOL;
}
