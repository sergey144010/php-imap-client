<?php

namespace sergey144010\ImapClient\Connect;


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