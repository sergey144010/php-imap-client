# Usage

#### After install prep
After you install this library ensure you have added the required classes.
A basic connection may look like this:
```php
use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\ImapClientSimple;

try{

$imapClient = ImapClientSimple::connect('imap.server.com', 'user', 'pass');

/* and further code */

}catch (ImapClientException $e){
    echo $e->getInfo();
};              
```
The above code connects you to a mail server and makes sure it connected.
Change the variables to your information

If you need more connection settings, see [Advanced connection](AdvancedConnecting.md)

#### After connection
There are many things you can do after the code above.
For example you can get and echo all folders
```php
$folders = $imapClient->getFolders();
foreach($folders as $folder => $subFolder) {
    echo $folder.PHP_EOL;
    echo $subFolder.PHP_EOL;
}
```
See [getFolders()](Methods.md#getfolders) method settings.

You can also select folders
```php
$imapClient->selectFolder("INBOX");
# or depending on the type of your separator
$imapClient->selectFolder("INBOX/Sent");
$imapClient->selectFolder("INBOX.Sent");
```

Once you selected a folder you can count the number of messages in the folder:
```php
$allMessages = $imapClient->countMessages();
$unreadMessages = $imapClient->countUnreadMessages();
$newMessages = $imapClient->countNewMessages();
```

To get a brief summary of all messages in the current folder,
including the message ID you can use this
```php
$imapClient->getShortInfoAboutMessages();
```

Get the message with ID 82
```php
$imapClient->getMessage(82);
```

Save all of the attachmets in this email.
```php
$imapClient->getMessageWithAttachments(82);
$imapClient->saveAttachments();
# or
$imapClient->saveAttachments(['dir'=>'dir/to/save']);
```

It is also possible to save all attachments for messages with a special word in the message subject.
```php
$imap->saveAttachmetsMessagesBySubject('Special text', 'path/to/save/attach');
```

Okay, now lets fetch all emails in the currently selected folder (in our example the "INBOX"):
```php
$emails = $imap->getMessages();
```
Now $emails it is array object.

The structure of a single message when it is received by the method getMessage() or getMessages()
it by the look here [Incoming Message](IncomingMessage.md)

For example get subject and simple text messages
```php
foreach($emails as $email){
    echo $email->getHeaders()->subject.PHP_EOL;
    echo $email->getBody()->plain.PHP_EOL;
};
```

You can also add/rename/delete folders. Lets add a new folder:

```php
$imap->addFolder('Archive');
```
Now we move the first email into this folder

```php
$imap->moveMessage($emails[0]['id'], 'archive');
```
And we delete the second email from inbox

```php
$imap->deleteMessage($emails[1]['id']);
```

We also can save emails
```php
$imap->saveEmail('archive/users/johndoe/email_1.eml', $id = 17 );
```

You can use the method of sending messages.
```php
$imap->sendMail();
```
But for this you need to take several steps.
[Adapter for outgoing message. Use in 3 steps.](AdapterForOutgoingMessage.md)

### More examples

See [Examples](Examples.md)

#### Advanced connecting

You can also use the below code to add some more options while connecting

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
 All connecting options you can see in example-connect.php file
 or go [Advanced connecting](AdvancedConnecting.md)
 or you can see code ImapConnect class.
