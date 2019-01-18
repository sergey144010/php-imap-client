<?php

namespace sergey144010\ImapClient\Incoming\Interfaces;


interface SkeletonInterface
{
    public function getStructure();
    public function getParts();
    public function getHeaders();
    public function getShortHeaders();
    public function getBody();
    public function getAttachments();

}