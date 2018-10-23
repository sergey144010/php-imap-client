<?php

namespace sergey144010\ImapClient\Incoming;


use sergey144010\ImapClient\ImapClient;
use sergey144010\ImapClient\Incoming\Interfaces\BuilderInterface;
use sergey144010\ImapClient\Incoming\Interfaces\MessageInterface;
use sergey144010\ImapClient\Incoming\Skeleton;
use sergey144010\ImapClient\MessageIdentifierInterface;
use sergey144010\ImapClient\MessageIdentifier;
use Zend\EventManager\EventManagerInterface;

class Builder implements BuilderInterface
{
    /**
     * @var string
     */
    private $flag;

    private $skeleton;

    /**
     * @var EventManagerInterface
     */
    private $events;

    /**
     * @var MessageIdentifierInterface
     */
    private $messageIdentifier;

    public function __construct()
    {
        $this->skeleton = new Skeleton();
    }

    public function setEvents(EventManagerInterface $events)
    {
        $this->events = $events;
    }

    protected function getEvents() : EventManagerInterface
    {
        return $this->events;
    }

    public function setFlag(string $flag) : void
    {
        $this->flag = $flag;
    }

    public function setIdentifier(MessageIdentifierInterface $identifier) : void
    {
        $this->skeleton->setIdentifier($identifier);
    }

    public function getMessage(MessageIdentifierInterface $messageIdentifier): MessageInterface
    {
        $this->messageIdentifier = $messageIdentifier;
        return $this->returnMessage();
    }

    public function getMessageStructure()
    {
        $this->skeleton->setIdentifier($this->messageIdentifier);
        #return $this->skeleton->getStructure();
    }

    public function getMessageBody()
    {
        $this->skeleton->setIdentifier($this->messageIdentifier);
        $this->skeleton->pullStructure();
        $this->skeleton->getParts();
        $this->skeleton->pullBody();
        /**
         * Here must be event like trigger()
         *
         *
         * LIKE THIS
         */
        $params = ['skeleton'=>$this->skeleton];
        $this->getEvents()->trigger(__FUNCTION__, $this, $params);

        if($this->getDecode() == ImapClient::ONN_DECODE) {
            $this->skeleton->decodeBody();
        };

        $message = new Message();
        $message->setBody($this->skeleton->getBody());
        return $message;
    }

    public function getDecode()
    {
        return ImapClient::$decode;
    }

    private function returnMessage()
    {
        switch ($this->flag)
        {
            case Message::STRUCTURE :
                return $this->getMessageStructure();
                break;
            case Message::PARTS :
                return $this->getMessageParts();
                break;
            case Message::HEADERS :
                return $this->getMessageHeaders();
                break;
            case Message::SHORT_HEADERS :
                return $this->getMessageShortHeaders();
                break;
            case Message::BODY :
                return $this->getMessageBody();
                break;
            case Message::ATTACHMENTS :
                return $this->getMessageAttachments();
                break;
            default :
                #return $this->getMessage($id);
                break;
        }
    }
}