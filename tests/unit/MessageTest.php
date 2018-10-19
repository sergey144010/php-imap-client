<?php
/**
 * Created by PhpStorm.
 * User: employee
 * Date: 18.10.2018
 * Time: 17:50
 */

namespace sergey144010\ImapClient\Tests;


use PHPUnit\Framework\TestCase;
use sergey144010\ImapClient\Incoming\Message;

#C:\projects\php-imap-client>vendor\bin\phpunit tests\unit\MessageTest.php
class MessageTest extends TestCase
{
    public function testCreateMessage()
    {
        $message = new Message();
        $message->setHeaders('123');
        $this->assertEquals('123', $message->getHeaders());
    }
}