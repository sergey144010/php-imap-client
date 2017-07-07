<?php

namespace sergey144010\ImapClient\IncomingMessage;


use sergey144010\ImapClient\MessageIdentifierInterface;
use sergey144010\ImapClient\Part;

class Attachments
{
    private $messageIdentifier;
    private $structure;
    private $parts;

    /**
     * @var array
     */
    private $attachments;

    public function __construct(
        MessageIdentifierInterface $messageIdentifier,
        $structure,
        $parts
    )
    {
        $this->messageIdentifier = $messageIdentifier;
        $this->structure = $structure;
        $this->parts = $parts;
    }

    /**
     * @return array
     */
    public function get()
    {
        if(!isset($this->attachments)){
            $this->getAttachments();
        };
        return $this->attachments;
    }

    private function getAttachments()
    {
        $attachments = [];
        $parts = (new AllowTypes($this->structure, $this->parts))->getParts(AllowTypes::PART_ATTACHMENTS);
        foreach ($parts as $part)
        {
            $body = Part::pullBody($this->messageIdentifier, $part['part']);
            $structure = Part::instance()->getPieceStructure($this->structure, $part['part']);
            $name = $this->getName($structure);

            $objNew = new \stdClass();
            /* Set name */
            $objNew->name = $name;
            /* Set charset */
            foreach ($structure->parameters as $parameter) {
                $attribute = strtolower($parameter->attribute);
                if($attribute == 'charset'){
                    $value = strtolower($parameter->value);
                    $objNew->charset = $value;
                };
            };
            /* Set body */
            $objNew->body = $body;
            /* Set structure */
            $objNew->structure = $structure;
            $attachments[] = $objNew;
        };
        $this->attachments = $attachments;
    }

    /**
     * @param object $structure
     * @return string
     */
    private function getName($structure)
    {
        // Check for different types of inline attachments.
        if ($structure->ifdparameters) {
            foreach ($structure->dparameters as $param) {
                if ($param->attribute == 'filename') {
                    return $param->value;
                };
            };
        }
        elseif($structure->ifparameters) {
            foreach ($structure->parameters as $param) {
                if ($param->attribute == 'name') {
                    return $param->value;
                };
            };
        };
        return '';
    }

}