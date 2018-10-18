<?php

namespace sergey144010\ImapClient\Incoming;


use sergey144010\ImapClient\Incoming\Interfaces\BuilderInterface;
use sergey144010\ImapClient\Incoming\Interfaces\MessageInterface;
use sergey144010\ImapClient\MessageIdentifierInterface;

class Builder implements BuilderInterface
{
    /**
     * @var string
     */
    private $flag;

    public function setFlag(string $flag) : void
    {
        $this->flag = $flag;
    }
    public function getMessage(MessageIdentifierInterface $messageIdentifier): MessageInterface
    {
        // TODO: Implement getMessage() method.
    }

    public function getMessageStructure($id)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        return $this->incomingMessage->getStructure();
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