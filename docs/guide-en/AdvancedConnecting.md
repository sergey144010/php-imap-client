
# Advanced Connecting

We also have ways to change how your connection works.
Read the code and examples below to learn some ways to modifiy your connection.

```php
use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\Connect\Flags;
use sergey144010\ImapClient\Connect\Mailbox;
use sergey144010\ImapClient\Connect\Parameters;
use sergey144010\ImapClient\Connect\ImapConnect;
use sergey144010\ImapClient\ImapClient;

try{

    $flags = new Flags(Flags::NOVALIDATE_CERT);
    $mailbox = new Mailbox( $server = 'imap.server.com', $port = 143, $flags, $folder = 'TestForImapClient' );
    $parameters = new Parameters($mailbox, 'user@server.com', 'password');

    $imapClient = new ImapClient(new ImapConnect($parameters)); 
    
    /* future code here */
    
}catch(ImapClientException $e){
    echo $e->getMessage();
};
```

Flags, see constants in Flags class:
```php
    Flags::SERVICE_IMAP
    Flags::SERVICE_POP3
    Flags::SERVICE_NNTP
    Flags::IMAP
    Flags::POP3
    Flags::NNTP
    Flags::SSL
    Flags::TLS
    Flags::NOTLS
    Flags::VALIDATE_CERT
    Flags::NOVALIDATE_CERT
    Flags::DEBUG
    Flags::SECURE
    Flags::NORSH
    Flags::READONLY
    Flags::ANONYMOUS
```

Flags, port and folder may be null, like
```php
$mailbox = new Mailbox( $server = 'imap.server.com', $port = null, $flags = null, $folder = null );
$mailbox = new Mailbox( $server = 'imap.server.com' );
```