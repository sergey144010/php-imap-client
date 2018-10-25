<?php

namespace sergey144010\ImapClient\Incoming\Interfaces;

use sergey144010\ImapClient\Incoming\Interfaces\SetIdentifierInterface;

interface SkeletonInterface extends SetIdentifierInterface
{
    public function getStructure();
    public function getParts();
    public function getHeaders();
    public function getShortHeaders();
    public function getBody();
    public function getAttachments();

}