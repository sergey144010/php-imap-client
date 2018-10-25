<?php

namespace sergey144010\ImapClient\Tests;

use PHPUnit\Framework\TestCase;
use sergey144010\ImapClient\ImapClient;
use sergey144010\ImapClient\Incoming\Message;
use sergey144010\ImapClient\Incoming\Skeleton;
use sergey144010\ImapClient\Incoming\Interfaces\SkeletonInterface;
use sergey144010\ImapClient\Incoming\Builder;

use sergey144010\ImapClient\MessageIdentifier;
use Zend\EventManager\EventManager;

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

    /*
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
    */

    public function testSkeletonStub()
    {
        $mock = $this->createMock(Skeleton::class);

        $structure = 'This is a structure';
        $parts = 'This is a parts';
        $headers = 'This is a headers';
        $shortHeaders = 'This is a short headers';
        $body = 'This is a body';
        $attachments = 'This is a attachments';

        $mock->method('getStructure')->willReturn($structure);
        $mock->method('getParts')->willReturn($parts);
        $mock->method('getHeaders')->willReturn($headers);
        $mock->method('getShortHeaders')->willReturn($shortHeaders);
        $mock->method('getBody')->willReturn($body);
        $mock->method('getAttachments')->willReturn($attachments);

        /** @var SkeletonInterface $stub */
        $stub = $mock;
        $this->assertSame($structure, $stub->getStructure());
        $this->assertSame($parts, $stub->getParts());
        $this->assertSame($headers, $stub->getHeaders());
        $this->assertSame($shortHeaders, $stub->getShortHeaders());
        $this->assertSame($body, $stub->getBody());
        $this->assertSame($attachments, $stub->getAttachments());
    }

    public function testBuilderGetMessageBodyDefault()
    {
        $stub = $this->createMock(Skeleton::class);
        $body = 'This is a body';
        $stub->method('getBody')->willReturn($body);
        $stub->method('decodeBody')->willReturn(null);

        $builder = new Builder();
        $builder->setEvents(new EventManager());
        $builder->setFlag(Message::BODY);
        $builder->setSkeleton($stub);
        $message = $builder->getMessage(new MessageIdentifier(null, 111, null));

        $this->assertSame($body, $message->getBody());
    }

    public function testBuilderGetMessageStructure()
    {
        $stub = $this->createMock(Skeleton::class);
        $structure = 'This is a structure';
        $stub->method('getStructure')->willReturn($structure);

        $builder = new Builder();
        $builder->setEvents(new EventManager());
        $builder->setFlag(Message::STRUCTURE);
        $builder->setSkeleton($stub);
        $message = $builder->getMessage(new MessageIdentifier(null, 111, null));

        #$this->assertSame($structure, $message->);
    }

}