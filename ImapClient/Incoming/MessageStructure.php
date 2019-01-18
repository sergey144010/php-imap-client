<?php
/**
 * Created by PhpStorm.
 * User: employee
 * Date: 18.01.2019
 * Time: 17:02
 */

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
}