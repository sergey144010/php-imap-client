<?php

namespace sergey144010\ImapClient\IncomingMessage;


use sergey144010\ImapClient\MessageIdentifierInterface;
use sergey144010\ImapClient\Part;

class Body
{
    private $messageIdentifier;
    private $structure;
    private $parts;

    private $body;

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

    public function get()
    {
        if(!isset($this->body)){
            $this->getBody();
        };
        return $this->body;
    }

    /**
     * Get body current message
     *
     * Set
     * $this->body->$subtype->structure
     * $this->body->$subtype->body
     * $this->body->$subtype->charset
     *
     * @return void
     */
    private function getBody()
    {
        $objNew = new \stdClass(); $i = 1;
        $parts = (new AllowTypes($this->structure, $this->parts))->getParts(AllowTypes::PART_BODY);
        foreach ($parts as $part)
        {
            $body = Part::pullBody($this->messageIdentifier, $part['part']);
            $structure = Part::instance()->getPieceStructure($this->structure, $part['part']);

            $subtype = strtolower($structure->subtype);

            if(isset($objNew->$subtype)){
                $subtype = $subtype.'_'.$i;
                $i++;
            };
            $objNew->types[] = $subtype;
            $objNew->$subtype = (new Subtype())->setBody($body);
            $objNew->$subtype->setStructure($structure);

            /*
             * Set charset
             */

            foreach ($structure->parameters as $parameter) {
                $attribute = strtolower($parameter->attribute);
                if($attribute == 'charset'){
                    $value = strtolower($parameter->value);
                    $objNew->$subtype->setCharset($value);
                };
            };

        };
        if(isset($objNew->plain)){
            $objNew->text = $objNew->plain;
            $objNew->types[] = 'text';
        };
        $this->body = $objNew;
    }
}