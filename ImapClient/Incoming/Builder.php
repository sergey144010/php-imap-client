<?php

namespace sergey144010\ImapClient\Incoming;


use sergey144010\ImapClient\ImapClient;
use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\Incoming\Interfaces\SkeletonInterface;
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

    }

    public function setSkeleton(SkeletonInterface $skeleton) : void
    {
        $this->skeleton = $skeleton;
    }

    public function createSkeleton() : void
    {
        $this->skeleton = new Skeleton();
    }

    public function setEvents(EventManagerInterface $events)
    {
        $this->events = $events;
    }

    public function setFlag(string $flag) : void
    {
        $this->flag = $flag;
    }

    public function setIdentifier(MessageIdentifierInterface $identifier) : void
    {
        $this->skeleton->setIdentifier($identifier);
    }

    public function getMessage(): MessageInterface
    {
        return $this->returnMessage();
    }

    public function getMessageStructure() : Message
    {
        $this->skeleton = $this->getSkeleton();
        $this->skeleton->setIdentifier($this->messageIdentifier);
        return $this->skeleton->getStructure();
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
            case Message::DEFAULT :
                return $this->getMessage();
                break;
            default :
                return $this->getMessage();
                break;
        }
    }

    private function getSkeleton() : SkeletonInterface
    {
        if(!isset($this->skeleton)){
            throw new ImapClientException('Skeleton not set');
        };
        return $this->skeleton;
    }

    private function getEvents() : EventManagerInterface
    {
        if(!isset($this->events)){
            throw new ImapClientException('Events not set');
        };
        return $this->events;
    }

    private function getMessageBody() : MessageInterface
    {
        $this->skeleton = $this->getSkeleton();
        $this->skeleton->setIdentifier($this->messageIdentifier);
        $this->skeleton->getStructure();
        $this->skeleton->getParts();
        $this->skeleton->getBody();

        $params = [
            'id' => $this->messageIdentifier->getId(),
            'body' => $this->skeleton->getBody(),
            ImapClient::DECODE_BODY_OFF => false,
            ImapClient::DECODE_BODY_CUSTOM => false,
        ];
        $params = $this->getEvents()->prepareArgs($params);
        $this->getEvents()->trigger(ImapClient::DECODE_BODY, $this, $params);
        if($params[ImapClient::DECODE_BODY_OFF]){
            $body = $this->skeleton->getBody();
        } elseif ($params[ImapClient::DECODE_BODY_CUSTOM]){
            $body = $params['body'];
        }else{
            $this->skeleton->decodeBody();
            $body = $this->skeleton->getBody();
        };

        $message = new Message();
        $message->setBody($body);
        return $message;
    }
}