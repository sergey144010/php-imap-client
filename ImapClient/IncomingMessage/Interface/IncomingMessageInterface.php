<?php

namespace sergey144010\ImapClient\IncomingMessage;


use sergey144010\ImapClient\MessageIdentifierInterface;

interface IncomingMessageInterface
{
    public function setIdentifier(MessageIdentifierInterface $identifier);

    public function getStructure();
    public function getPieceStructure($part);
    public function getParts();
    public function getHeaders();
    public function getShortHeaders();
    public function getBody();
    public function getAttachments();

    public function pullStructure();
    public function pullHeaders();
    public function pullShortHeaders();
    public function pullPart($part);
    public function pullPartStructure($part);
    public function pullBody();
    public function pullAttachments();

    public function decodeAll();
    public function decodeHeaders();
    public function decodeShortHeaders();
    public function decodeBody();
    public function decodeAttachments();
}