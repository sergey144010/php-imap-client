# Examples

## Simple

### Get messages in 'INBOX.Sent' folder
```php
use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\ImapClientSimple;

try{

$imapClient = ImapClientSimple::connect('imap.server.com', 'user', 'pass');
$imapClient->selectFolder('INBOX.Sent');
$emails = $imapClient->getMessages();
foreach($emails as $email){
    echo $email->getHeaders()->subject.PHP_EOL;
    echo $email->getBody()->plain.PHP_EOL;
};


}catch(ImapClientException $e){
    echo $e->getMessage();
};
```
For advanced connecting see advanced part.

### Get message with ID 8 in 'INBOX.Sent' folder
```php
use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\ImapClientSimple;

try{

$imapClient = ImapClientSimple::connect('imap.server.com', 'user', 'pass');
$imapClient->selectFolder('INBOX.Sent');
$email = $imapClient->getMessage(8);
echo $email->getHeaders()->subject.PHP_EOL;
echo $email->getBody()->plain.PHP_EOL;


}catch(ImapClientException $e){
    echo $e->getMessage();
};
```

### Get message with ID 8 and its attachments in 'INBOX.Sent' folder
```php
use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\ImapClientSimple;

try{

$imapClient = ImapClientSimple::connect('imap.server.com', 'user', 'pass');
$imapClient->selectFolder('INBOX.Sent');
$email = $imapClient->getMessageWithAttachments(8);
$imapClient->saveAttachments(['dir'=>'path/to/attachment']);
echo $email->getHeaders()->subject.PHP_EOL;
echo $email->getBody()->plain.PHP_EOL;

}catch(ImapClientException $e){
    echo $e->getMessage();
};
```

### Get message headers only
```php
echo $imapClient->getMessageHeaders(8);
```
### Get message short headers only
```php
echo $imapClient->getMessageShortHeaders(8);
```
### Get message body only
```php
echo $imapClient->getMessageBody(8);
```
### Get message attachments only
```php
echo $imapClient->getMessageAttachments(8);
```
### Get message parts only
```php
echo $imapClient->getMessageParts(8);
```
### Get message structure only
```php
echo $imapClient->getMessageStructure(8);
```

### Get messages with attachments in 'INBOX.Sent' folder
```php
use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\ImapClientSimple;

try{

$imapClient = ImapClientSimple::connect('imap.server.com', 'user', 'pass');
$imapClient->selectFolder('INBOX.Sent');

$imapClient->useGetMessageWithAttachments();
$emails = $imapClient->getMessages();

foreach($emails as $email){
    $imapClient->saveAttachments(['dir'=>'path/to/attachment']);
    echo $email->getHeaders()->subject.PHP_EOL;
    echo $email->getBody()->plain.PHP_EOL;
};


}catch(ImapClientException $e){
    echo $e->getMessage();
};
```

### Get messages headers only
```php
use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\ImapClientSimple;

try{

$imapClient = ImapClientSimple::connect('imap.server.com', 'user', 'pass');
$imapClient->selectFolder('INBOX.Sent');

$imapClient->useGetMessageHeaders();
$emails = $imapClient->getMessages();

foreach($emails as $email){
    echo $email->subject.PHP_EOL;
};


}catch(ImapClientException $e){
    echo $e->getMessage();
};
```
Similarly, you can use methods:
```php
$imapClient->useGetMessageHeaders();
$imapClient->useGetMessageShortHeaders();
$imapClient->useGetMessageBody();
$imapClient->useGetMessageAttachments();
$imapClient->useGetMessageParts();
$imapClient->useGetMessageStructure();
```

### Use message ID
````php
$imapClient->useID();
$imapClient->getMessage($id = 8);
````

### Use message UID
````php
$imapClient->useUID();
$imapClient->getMessage($uid = 394875);
````

## Advanced

### Use advanced connecting
```php
use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\Connect\Flags;
use sergey144010\ImapClient\Connect\Mailbox;
use sergey144010\ImapClient\Connect\Parameters;
use sergey144010\ImapClient\Connect\ImapConnect;
use sergey144010\ImapClient\ImapClient;

try{

$flags = new Flags(Flags::NOVALIDATE_CERT);
$mailbox = new Mailbox('imap.server.com', $port = 143, $flags, 'INBOX/TestForImapClient');
$parameters = new Parameters($mailbox, 'user@server.com', 'password');

$imapClient = new ImapClient(new ImapConnect($parameters));

}catch(ImapClientException $e){
    echo $e->getMessage();
};
```