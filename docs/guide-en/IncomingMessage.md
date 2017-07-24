# Incoming Message

Incoming Message has the following structure:

```php
    /* object */
    private $structure;

    /* array */
    private $parts;

    /* object */
    private $headers;

    /* object */
    private $shortHeaders;

    /* \stdClass object */
    private $body;

    /* array */
    private $attachments;
```

The incoming letter can be obtained as follows:
```php
$imapClient = ImapClientSimple::connect(...);
$email = $imapClient->getMessage(83);
# or
$email = $imapClient->getMessageWithAttachments(83);
# or array messages
$emails = $imapClient->getMessages();
```

To get these properties, use the appropriate methods:
```php
getStructure();
getParts();
getHeaders();
getShortHeaders();
getBody();
getAttachments();
```

like
```php
$email->getStructure();
$email->getParts();
$email->getHeaders();
$email->getShortHeaders();
$email->getBody();
$email->getAttachments();
```

And to receive the text of the letter it is possible so:
```php
$email->getBody()->html;
# or
$email->getBody()->plain;
# or
$email->getBody()->text;
```

Get subject
```php
$email->getHeaders()->subject;
```

Types of message, like html or plain, can be obtained this way
```php
$email->getBody()->types
```

### getMessage()

Method getMessage() return one message
and does not contain the property 'attachments', or rather it is NULL.
```php
$imapClient = ImapClientSimple::connect(...);
$email = $imapClient->getMessage(83);
$email->getAttachments(); // return NULL
```

### getMessageWithAttachments()

Method getMessageWithAttachments() return one message with its attachments,
contain in the property 'attachments'.
```php
$imapClient = ImapClientSimple::connect(...);
$email = $imapClient->getMessageWithAttachments(83);
$email->getAttachments(); // return array whith attachments
```

Example var_dump() incoming message obtained through getMessageWithAttachments() see here
[Example incoming message var_dump()](DumpIncomingMessage.md)

### Override getMessages() method

You can redefine the behavior of this method in the following way.
Use methods:
```php
$imapClient->useGetMessageHeaders();
$imapClient->useGetMessageShortHeaders();
$imapClient->useGetMessageBody();
$imapClient->useGetMessageAttachments();
$imapClient->useGetMessageParts();
$imapClient->useGetMessageStructure();
$imapClient->useGetMessage();
$imapClient->useGetMessageWithAttachments()
```

like this
```php
$imapClient->useGetMessageHeaders();
$emails = $imapClient->getMessages();
```
Return an array of message headers.

You can receive all messages with attachments as follows:
```php
$imapClient->useGetMessageWithAttachments()
$emails = $imapClient->getMessages();
```

Only the body of messages can be received:
```php
$imapClient->useGetMessageBody();
$emails = $imapClient->getMessages();
```