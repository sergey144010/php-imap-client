<?php

namespace sergey144010\ImapClient\Incoming;

use sergey144010\ImapClient\Incoming\Interfaces\SkeletonInterface;
use sergey144010\ImapClient\MessageIdentifierInterface;
use sergey144010\ImapClient\ImapHelper;
use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\Part;


class Skeleton implements SkeletonInterface
{
    /**
     * @var MessageIdentifierInterface
     */
    private $messageIdentifier;

    /**
     * @var object
     */
    private $structure;

    /**
     * @var array
     */
    private $parts;

    /**
     * @var object
     */
    private $headers;

    /**
     * @var object
     */
    private $shortHeaders;

    /**
     * @var \stdClass object
     */
    private $body;

    /**
     * @var array
     */
    private $attachments;

    public function setIdentifier(MessageIdentifierInterface $identifier) : void
    {
        $this->messageIdentifier = $identifier;

        $this->structure = null;
        $this->parts = null;
        $this->headers = null;
        $this->body = null;
        $this->attachments = null;
    }

    public function getStructure()
    {
        if(!isset($this->structure)) {
            $this->pullStructure();
        };
        return $this->structure;
    }

    public function getParts()
    {
        if(!isset($this->parts)){
            $this->checkStructure();
            $this->parts = (new CalculateParts($this->structure))->getParts();
        };
        return $this->parts;
    }

    public function getHeaders()
    {
        if(!isset($this->headers)){
            $this->pullHeaders();
        };
        return $this->headers;
    }

    public function getShortHeaders()
    {
        if(!isset($this->shortHeaders)){
            $this->pullShortHeaders();
        };
        return $this->shortHeaders;
    }

    public function getBody()
    {
        if(!isset($this->body)){
            $this->pullBody();
        };
        return $this->body;
    }

    public function getAttachments()
    {
        if(!isset($this->attachments)){
            $this->pullAttachments();
        };
        return $this->attachments;
    }

    private function pullStructure()
    {
        $this->checkIdentifier();
        $this->structure = ImapHelper::imapFetchStructure($this->messageIdentifier);
        return $this;
    }

    private function pullHeaders()
    {
        $this->checkIdentifier();
        $this->headers = ImapHelper::imapHeaderInfo($this->messageIdentifier);
        return $this;
    }

    private function pullShortHeaders()
    {
        $this->checkIdentifier();
        $this->shortHeaders = ImapHelper::imapFetchOverview($this->messageIdentifier)[0];
        return $this;
    }

    private function pullBody()
    {
        $this->checkIdentifier();
        $this->checkStructure();
        $this->checkParts();
        $this->body = (new Body($this->messageIdentifier, $this->structure, $this->parts))->get();
        return $this;
    }

    private function pullAttachments()
    {
        $this->checkIdentifier();
        $this->checkStructure();
        $this->checkParts();
        $this->attachments = (new Attachments($this->messageIdentifier, $this->structure, $this->parts))->get();
        return $this;
    }

    private function pullPart($part)
    {
        return ImapHelper::imapFetchBody($this->messageIdentifier, $part);
    }

    private function pullPartStructure($part)
    {
        return ImapHelper::imapBodyStruct($this->messageIdentifier, $part);
    }

    public function getPieceStructure($part)
    {
        $this->checkStructure();
        return Part::instance()->getPieceStructure($this->structure, $part);
    }

    public function decodeAll()
    {
        $this->decodeHeaders();
        $this->decodeShortHeaders();
        $this->decodeBody();
        $this->decodeAttachments();
    }

    public function decodeHeaders()
    {
        if(isset($this->headers->subject)){
            $this->headers->subject = $this->mimeHeaderDecode($this->headers->subject);
        };
        if(isset($this->headers->Subject)){
            $this->headers->Subject = $this->mimeHeaderDecode($this->headers->Subject);
        };
    }

    public function decodeShortHeaders()
    {
        if(isset($this->shortHeaders->subject)){
            $this->shortHeaders->subject = $this->mimeHeaderDecode($this->shortHeaders->subject);
        };
        if(isset($this->shortHeaders->from)){
            $this->shortHeaders->from = $this->mimeHeaderDecode($this->shortHeaders->from);
        };
        if(isset($this->shortHeaders->to)){
            $this->shortHeaders->to = $this->mimeHeaderDecode($this->shortHeaders->to);
        };
    }

    public function decodeBody()
    {
        if(isset($this->body->types) && is_array($this->body->types)){
            foreach ($this->body->types as $typeMessage) {

                /**
                 * @var Subtype $typeMessage
                 */

                /*
                switch ($this->body->$typeMessage->structure->encoding)
                {
                    case 3:
                        $this->body->$typeMessage->body = imap_base64($this->body->$typeMessage->body);
                        break;
                    case 4:
                        $this->body->$typeMessage->body = imap_qprint($this->body->$typeMessage->body);
                        break;
                };
                */

                switch ($this->body->$typeMessage->getStructure()->encoding) {
                    case 3:
                        $this->body->$typeMessage->setBody(imap_base64($this->body->$typeMessage->getBody()));
                        break;
                    case 4:
                        $this->body->$typeMessage->setBody(imap_qprint($this->body->$typeMessage->getBody()));
                        break;
                };

            }
        }
    }

    public function decodeAttachments()
    {
        if(isset($this->attachments) && is_array($this->attachments))
        {
            foreach ($this->attachments as $key => $attachment) {
                /* Decode body */
                switch ($attachment->structure->encoding) {
                    case 3:
                        $this->attachments[$key]->body = imap_base64($attachment->body);
                        break;
                    case 4:
                        $this->attachments[$key]->body = quoted_printable_decode($attachment->body);
                        break;
                };
                /* Decode name */
                $this->attachments[$key]->name = $this->mimeHeaderDecode($attachment->name);
            }
        }
    }

    /**
     * Decodes and glues the title bar
     *
     * @see http://php.net/manual/ru/function.imap-mime-header-decode.php
     * @param string $string
     * @return string
     */
    private function mimeHeaderDecode($string)
    {
        $cache = null;
        $array = ImapHelper::imapMimeHeaderDecode($string);
        foreach ($array as $object) {
            $cache .= $object->text;
        };
        return $cache;
    }

    private function checkIdentifier()
    {
        if(!isset($this->messageIdentifier)){
            throw new ImapClientException('Property MessageIdentifier is NULL');
        };
    }

    private function checkStructure()
    {
        if(!isset($this->structure)){
            throw new ImapClientException('Property Structure is NULL');
        };
    }

    private function checkParts()
    {
        if(!isset($this->parts)){
            throw new ImapClientException('Property Parts is NULL');
        };
    }

}
