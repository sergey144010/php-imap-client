<?php

namespace sergey144010\ImapClient\Connect\Interfaces;


interface ImapConnectInterface
{
    /**
     * @return resource
     */
    public function getStream();

    /**
     * @return ParametersInterface
     */
    public function getParameters();
}