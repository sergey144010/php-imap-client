<?php
/**
 * Created by PhpStorm.
 * User: Sergey144010
 * Date: 17.07.2017
 * Time: 5:08
 */

namespace sergey144010\ImapClient\IncomingMessage\Interfaces;


interface TypeInterface
{
    public function getList();
    public function validate($structure, $subtype);
}