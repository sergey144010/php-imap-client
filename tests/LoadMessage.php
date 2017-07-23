<?php

namespace sergey144010\ImapClient\Tests;


class LoadMessage extends Message
{

    private $defaultFileName = 'emails/plain.eml';

    /**
     * @return LoadMessage
     */
    public static function instance()
    {
        return new self();
    }

    public function loadFile($fileName = null)
    {
        if(!isset($fileName)){
            $this->body = file_get_contents($this->defaultFileName);
        }else{
            $this->body = file_get_contents($fileName);
        };
        return $this;
    }
}