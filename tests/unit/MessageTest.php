<?php
/**
 * Created by PhpStorm.
 * User: employee
 * Date: 18.10.2018
 * Time: 17:50
 */

namespace sergey144010\ImapClient\Tests;


use PHPUnit\Framework\TestCase;
use sergey144010\ImapClient\ImapClient;
use sergey144010\ImapClient\Incoming\Message;

#C:\projects\php-imap-client>vendor\bin\phpunit --debug tests\unit\MessageTest.php
class MessageTest extends TestCase
{
    /*
    public function testCreateMessage()
    {
        $message = new Message();
        $message->setHeaders('123');
        $this->assertEquals('123', $message->getHeaders());
    }
    */
    /*
    public function oldTestEvents()
    {
        $imapClient = new ImapClient();

        $id1 = 333;
        $id2 = '';

        $imapClient->getEventManager()->attach('deleteThisMethod', function ($e) use (&$id2) {
            $params = $e->getParams();
            $id2 = $params['id'];
        });

        #$imapClient->deleteThisMethod(333);
        $this->assertEquals($id1, $id2);
    }
    */

    public function testImapClient()
    {
        $imapClient = new ImapClient();
        $imapClient->getEventManager()->attach(ImapClient::DECODE_BODY, function($e){
            $params = $e->getParams();
            $e->setParam(ImapClient::CUSTOM_DECODE_BODY, true);
            $e->setParam('body', '33333333333333333333333333333');
        });
        $message = $imapClient->getMessage(123, Message::BODY);
        $this->assertEquals('33333333333333333333333333333', $message->getBody());
    }
}