<?php

namespace sergey144010\ImapClient\Incoming;


use sergey144010\ImapClient\ImapClient;
use sergey144010\ImapClient\Incoming\Interfaces\BuilderInterface;
use sergey144010\ImapClient\Incoming\Interfaces\MessageInterface;
use sergey144010\ImapClient\IncomingMessage\Skeleton;
use sergey144010\ImapClient\MessageIdentifierInterface;
use sergey144010\ImapClient\MessageIdentifier;

class Builder implements BuilderInterface
{
    /**
     * @var string
     */
    private $flag;

    private $skeleton;

    public function __construct()
    {
        $this->skeleton = new Skeleton();
    }

    public function setFlag(string $flag) : void
    {
        $this->flag = $flag;
    }

    public function getMessage(MessageIdentifierInterface $messageIdentifier): MessageInterface
    {
        // TODO: Implement getMessage() method.
    }

    public function setIdentifier(MessageIdentifierInterface $identifier) : void
    {
        $this->skeleton->setIdentifier($identifier);
    }

    public function getMessageStructure($id)
    {
        $this->skeleton->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        #return $this->skeleton->getStructure();
    }

    public function getMessageBody($id)
    {
        $this->skeleton->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        $this->skeleton->pullStructure();
        $this->skeleton->getParts();
        $this->skeleton->pullBody();
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

    private function returnMessage($id, $const = null)
    {
        switch ($const)
        {
            case Message::STRUCTURE :
                return $this->getMessageStructure($id);
                break;
            case Message::PARTS :
                return $this->getMessageParts($id);
                break;
            case Message::HEADERS :
                return $this->getMessageHeaders($id);
                break;
            case Message::SHORT_HEADERS :
                return $this->getMessageShortHeaders($id);
                break;
            case Message::BODY :
                return $this->getMessageBody($id);
                break;
            case Message::ATTACHMENTS :
                return $this->getMessageAttachments($id);
                break;
            default :
                #return $this->getMessage($id);
                break;
        }
    }
}