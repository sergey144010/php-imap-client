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

    /**
     * @var Skeleton
     */
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

        $params = [
            'id' => $this->messageIdentifier->getId(),
            'body' => $this->skeleton->getBody(),
            ImapClient::DEFAULT_DECODE_BODY => false,
            ImapClient::CUSTOM_DECODE_BODY => false,
        ];
        $params = $this->getEvents()->prepareArgs($params);
        $this->getEvents()->trigger(ImapClient::DECODE_BODY, $this, $params);
        if($params[ImapClient::DEFAULT_DECODE_BODY]){
            $this->skeleton->decodeBody();
            $body = $this->skeleton->getBody();
        }elseif ($params[ImapClient::CUSTOM_DECODE_BODY]){
            $body = $params['body'];
        }else{
            $body = $this->skeleton->getBody();
        };

        $message = new Message();
        $message->setBody($body);
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