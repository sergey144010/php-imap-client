<?php

namespace sergey144010\ImapClient;


interface GetMessageInterface
{
    public function getMessageStructure($id);
    public function getMessageParts($id);
    public function getMessageHeaders($id);
    public function getMessageShortHeaders($id);
    public function getMessageBody($id);
    public function getMessage($id);
    public function getMessageWithAttachments($id);
    public function getMessageAttachments($id);
}