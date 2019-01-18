<?php

namespace sergey144010\ImapClient\Incoming\Interfaces;


interface MessageStructureInterface
{
    public function getStructure();
    public function getParts();
    public function getShortHeaders();
}