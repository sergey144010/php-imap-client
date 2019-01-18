<?php

namespace sergey144010\ImapClient\Incoming;


use sergey144010\ImapClient\Incoming\Interfaces\MessageStructureInterface;

class MessageStructure implements MessageStructureInterface
{
    private $structure;
    private $parts;
    private $shortHeaders;

    public function getStructure()
    {
        return $this->structure;
    }

    public function getParts()
    {
        return $this->parts;
    }

    public function getShortHeaders()
    {
        return $this->shortHeaders;
    }

    protected function setStructure($structure)
    {
        $this->structure = $structure;
    }

    protected function setParts($parts)
    {
        $this->parts = $parts;
    }

    protected function setShortHeaders($shortHeaders)
    {
        $this->shortHeaders = $shortHeaders;
    }
}