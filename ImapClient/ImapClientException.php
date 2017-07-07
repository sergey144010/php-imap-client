<?php

namespace sergey144010\ImapClient;


use \Exception;

class ImapClientException extends Exception
{
    /**
     * Get info about errors
     *
     * @return string
     */
    public function getInfo()
    {
        $error  = $this->getMessage().PHP_EOL;
        $error .= 'File: '.$this->getFile().PHP_EOL;
        $error .= 'Line: '.$this->getLine().PHP_EOL;
        return $error;
    }
}
