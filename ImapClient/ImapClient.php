<?php
/**
 * Copyright (C) 2017 Sergey144010
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

namespace sergey144010\ImapClient;


use sergey144010\ImapClient\Connect\Interfaces\ImapConnectInterface;
use sergey144010\ImapClient\Incoming\Builder;
use sergey144010\ImapClient\IncomingMessage\Interfaces\IncomingMessageInterface;
use sergey144010\ImapClient\IncomingMessage\IncomingMessage;
#use sergey144010\ImapClient\IncomingMessage\Message;
use sergey144010\ImapClient\IncomingMessage\TypeAttachments;

use sergey144010\ImapClient\Incoming\Interfaces\BuilderInterface;
use sergey144010\ImapClient\Incoming\Interfaces\MessageInterface;
use sergey144010\ImapClient\Incoming\Message;

/**
 * Class ImapClient is helper class for imap access
 *
 * @package    protocols
 * @copyright  Copyright (C) Sergey144010
 * @author     Sergey144010
 */
#class ImapClient implements GetMessageInterface
class ImapClient
{
    const ID = 0;
    const UID = 1;

    const STRUCTURE = 'structure';
    const PARTS = 'parts';
    const HEADERS = 'headers';
    const SHORT_HEADERS = 'shortHeaders';
    const BODY = 'body';
    const MESSAGE = 'message';
    const MESSAGE_WITH_ATTACHMENTS = 'messageWithAttachments';
    const ATTACHMENTS = 'attachments';

    const DESC = 'desc';
    const ASC = 'asc';

    const ONN_DECODE = 0;
    const OFF_DECODE = 1;

    /**
     * Subscribe to a folder
     */
    const SUBSCRIBE = 'subscribe';

    /**
     * @var IncomingMessageInterface
     */
    private $incomingMessage;

    /**
     * @var resource
     */
    private $stream;

    /**
     * @var Connect\Interfaces\ParametersInterface
     */
    private $parameters;

    private $identifier = self::ID;
    private $saveIdentifier;

    private $decode = self::ONN_DECODE;

    /**
     * @var array
     */
    private $attachments;

    private $getMessageConstant;

    /**
     * @var BuilderInterface
     */
    private $builder;

    public function __construct(ImapConnectInterface $imap)
    {
        $this->connect($imap);
        #$this->incomingMessage = new IncomingMessage();
        $this->builder = new Builder();
    }

    public function connect(ImapConnectInterface $stream)
    {
        $this->stream = $stream->getStream();
        $this->parameters = $stream->getParameters();
    }

    public function disConnect()
    {
        if (is_resource($this->stream)) {
            imap_close($this->stream);
        }
    }

    public function isConnected()
    {
        if(is_resource($this->stream)){
            return true;
        };
        return false;
    }

    public function useID()
    {
        $this->identifier = self::ID;
    }

    public function useUID()
    {
        $this->identifier = self::UID;
    }

    public function saveIdentifier()
    {
        $this->saveIdentifier = $this->identifier;
    }

    public function restoreIdentifier()
    {
        $this->identifier = $this->saveIdentifier;
    }

    public function getUID($id)
    {
        return ImapHelper::getUID(new MessageIdentifier($this->stream, $id, $this->identifier));
    }

    public function getID($uid)
    {
        return ImapHelper::getID(new MessageIdentifier($this->stream, $uid, $this->identifier));
    }

    public function getImapLastError()
    {
        return imap_last_error();
    }

    public function getConnectParameters()
    {
        return $this->parameters;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getIncomingMessageObject()
    {
        return $this->incomingMessage;
    }

    public function setIncomingMessageObject(IncomingMessageInterface $obj)
    {
        $this->incomingMessage = $obj;
    }

    public function useGetMessageStructure()
    {
        $this->getMessageConstant = self::STRUCTURE;
    }

    public function useGetMessageParts()
    {
        $this->getMessageConstant = self::PARTS;
    }

    public function useGetMessageHeaders()
    {
        $this->getMessageConstant = self::HEADERS;
    }

    public function useGetMessageShortHeaders()
    {
        $this->getMessageConstant = self::SHORT_HEADERS;
    }

    public function useGetMessageBody()
    {
        $this->getMessageConstant = self::BODY;
    }

    public function useGetMessage()
    {
        $this->getMessageConstant = self::MESSAGE;
    }

    public function useGetMessageWithAttachments()
    {
        $this->getMessageConstant = self::MESSAGE_WITH_ATTACHMENTS;
    }

    public function onDecode()
    {
        $this->decode = self::ONN_DECODE;
    }

    public function offDecode()
    {
        $this->decode = self::OFF_DECODE;
    }

    public function getDecode()
    {
        return $this->decode;
    }

    public function offInlineInAttachments()
    {
        TypeAttachments::offInlineValidate();
    }

    public function onInlineInAttachments()
    {
        TypeAttachments::onInlineValidate();
    }

    public function getMessageStructure($id)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        return $this->incomingMessage->getStructure();
    }

    public function getMessageParts($id)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        $this->incomingMessage->pullStructure();
        return $this->incomingMessage->getParts();
    }

    public function getMessagePart($id, $part)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        return $this->incomingMessage->pullPart($part);
    }

    public function getMessagePartStructure($id, $part)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        return $this->incomingMessage->pullPartStructure($part);
    }

    public function getMessageHeaders($id)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        $this->incomingMessage->pullHeaders();
        if($this->getDecode() == self::ONN_DECODE){
            $this->incomingMessage->decodeHeaders();
        };
        return $this->incomingMessage->getHeaders();
    }

    public function getMessageShortHeaders($id)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        $this->incomingMessage->pullShortHeaders();
        if($this->getDecode() == self::ONN_DECODE) {
            $this->incomingMessage->decodeShortHeaders();
        };
        return $this->incomingMessage->getShortHeaders();
    }

    public function getMessageBody($id)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        $this->incomingMessage->pullStructure();
        $this->incomingMessage->getParts();
        $this->incomingMessage->pullBody();
        if($this->getDecode() == self::ONN_DECODE) {
            $this->incomingMessage->decodeBody();
        };
        return $this->incomingMessage->getBody();
    }

    /**
     * @param integer $id
     * @return Message
     */
    /*
    public function getMessage($id)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        $this->incomingMessage->pullStructure();
        $this->incomingMessage->pullHeaders();
        $this->incomingMessage->getParts();
        $this->incomingMessage->pullBody();
        if($this->getDecode() == self::ONN_DECODE) {
            $this->incomingMessage->decodeHeaders();
            $this->incomingMessage->decodeBody();
        };
        $obj = new Message();
        $obj->setParts($this->incomingMessage->getParts());
        $obj->setHeaders($this->incomingMessage->getHeaders());
        $obj->setBody($this->incomingMessage->getBody());
        return $obj;
    }
    */

    /**
     * Get message by ID or UID
     *
     * @param int $id
     * @param string $flag Message::DEFAULT
     * @see Message
     * @return MessageInterface
     */
    public function getMessage(int $id, string $flag = Message::DEFAULT): MessageInterface
    {
        $this->builder->setFlag($flag);
        $this->builder->getMessage(new MessageIdentifier($this->stream, $id, $this->identifier));
    }

    public function getMessageWithAttachments($id)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        $this->incomingMessage->pullStructure();
        $this->incomingMessage->pullHeaders();
        $this->incomingMessage->getParts();
        $this->incomingMessage->pullBody();
        $this->incomingMessage->pullAttachments();
        if($this->getDecode() == self::ONN_DECODE) {
            $this->incomingMessage->decodeHeaders();
            $this->incomingMessage->decodeBody();
            $this->incomingMessage->decodeAttachments();
        };
        $obj = new Message();
        $obj->setParts($this->incomingMessage->getParts());
        $obj->setHeaders($this->incomingMessage->getHeaders());
        $obj->setBody($this->incomingMessage->getBody());
        $this->attachments = $this->incomingMessage->getAttachments();
        $obj->setAttachments($this->attachments);
        return $obj;
    }

    /**
     * @param integer $id
     * @return array
     */
    public function getMessageAttachments($id)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        $this->incomingMessage->pullStructure();
        $this->incomingMessage->getParts();
        $this->incomingMessage->pullAttachments();
        if($this->getDecode() == self::ONN_DECODE) {
            $this->incomingMessage->decodeAttachments();
        };
        $this->attachments = $this->incomingMessage->getAttachments();
        return $this->attachments;
    }

    /**
     * Save attachments ONE incoming message
     *
     * The allowed types are TypeAttachments
     * You can add your own
     *
     * @param array $options have next parameters
     * ```php
     * # it is directory for save attachments
     * $options['dir']
     * ```
     * @return void
     */
    public function saveAttachments($options = null)
    {
        if(!isset($options['dir'])){
            $dir = __DIR__.DIRECTORY_SEPARATOR;
        }else{
            $dir = $options['dir'];
        };
        foreach ($this->attachments as $key => $attachment) {
            $newFileName = $attachment->name;
            file_put_contents($dir.DIRECTORY_SEPARATOR.$newFileName, $attachment->body);
        };
    }

    /**
     * @param $id
     * @return string
     */
    public function getMessageCharset($id)
    {
        $this->incomingMessage->setIdentifier(new MessageIdentifier($this->stream, $id, $this->identifier));
        $structure = $this->incomingMessage->getStructure();
        $params = $structure->parameters ?: [];
        foreach ($params as $k => $v) {
            if (stristr($v->attribute, 'charset')) {
                return $v->value;
            };
        };
        return '';
    }

    /** ALL messages in the CURRENT folder */
    public function countMessages()
    {
        $count = imap_num_msg($this->stream);
        if($count === false){
            throw new ImapClientException('Error getting count of messages');
        };
        return $count;
    }

    /** UNREAD messages in the CURRENT folder */
    public function countUnreadMessages()
    {
        $result = imap_search($this->stream, 'UNSEEN');
        if ($result === false) {
            return 0;
        }
        return count($result);
    }

    /** NEW messages in the CURRENT folder */
    public function countNewMessages()
    {
        return imap_num_recent($this->stream);
    }

    /**
     * Returns an array of short information about each message in the current mailbox.
     *
     * Returns the following structure of the array of arrays.
     * ```php
     * $array = [
     *     [ 'id'=>4, 'info'=>'brief info' ]
     *     [ 'id'=>5, 'info'=>'brief info' ]
     * ]
     *```
     * @return array
     */
    public function getShortInfoAboutMessages()
    {
        $array = imap_headers($this->stream);
        $newArray = [];
        foreach ($array as $key => $string) {
            $newArray[] = ['id'=>$key+1, 'info' => $string];
        };
        return $newArray;
    }

    /**
     * Select the given folder
     *
     * @param string $folder name
     * @return bool
     */
    public function selectFolder($folder)
    {
        return imap_reopen($this->stream, $this->parameters->getMailbox()->getServerPart() . $folder);
    }

    /**
     * Returns all available folders
     *
     * @param string $separator default is '.'
     * @param integer $type has three meanings 0,1,2.
     * If 0 return nested array, if 1 return an array of strings, if 2 return raw imap_list()
     * @return array with folder names
     */
    public function getFolders($separator = null, $type = 0)
    {
        $folders = imap_list($this->stream, $this->parameters->getMailbox()->getServerPart(), '*');
        if ($type == 2) {
            return $folders;
        };
        if ($type == 1) {
            return str_replace($this->parameters->getMailbox()->getServerPart(), '', $folders);
        };
        if ($type == 0) {
            $arrayRaw = str_replace($this->parameters->getMailbox()->getServerPart(), '', $folders);
            if (!isset($separator)) {
                $separator = '.';
            };
            $arrayNew = [];
            foreach ($arrayRaw as $string) {
                $array = explode($separator, $string);
                $count = count($array);
                $count = $count-1;
                $cache = false;
                for($i=$count; $i>=0; $i--){
                    if($i == $count){
                        $cache = [$array[$i]=>[]];
                    }else{
                        $cache = [$array[$i] => $cache];
                    };
                };
                $arrayNew = array_merge_recursive($arrayNew, $cache);
            };
            return $arrayNew;
        }
        return [];
    }

    /**
     * Add a new folder
     *
     * @param string $name of the folder
     * @param bool $subscribe immediately subscribe to folder, see self::SUBSCRIBE
     * @return void
     * @throws ImapClientException
     */
    public function addFolder($name, $subscribe = null)
    {
        $status = imap_createmailbox($this->stream, $this->parameters->getMailbox()->getServerPart() . $name);
        if($status === false){
            throw new ImapClientException('Add folder is failed');
        };
        if (isset($subscribe) && $subscribe === self::SUBSCRIBE) {
            $status = imap_subscribe($this->stream, $this->parameters->getMailbox()->getServerPart() . $name);
        };
        if($status === false){
            throw new ImapClientException('Subscribe is failed');
        };
    }

    /**
     * Rename a folder
     *
     * @param string $name of the folder
     * @param string $newName of the folder
     * @return void
     * @throws ImapClientException
     */
    public function renameFolder($name, $newName)
    {
        $status = imap_renamemailbox(
            $this->stream,
            $this->parameters->getMailbox()->getServerPart() . $name,
            $this->parameters->getMailbox()->getServerPart() . $newName
        );
        if($status === false){
            throw new ImapClientException('Rename folder is failed');
        };
    }

    public function currentFolderIsEmpty()
    {
        if($this->countMessages() == 0){
            return true;
        };
        return false;
    }

    /**
     * Deleting a folder
     *
     * @param string $name of the folder
     * @return void
     * @throws ImapClientException
     */
    public function deleteFolder($name)
    {
        $status = imap_deletemailbox($this->stream, $this->parameters->getMailbox()->getServerPart() . $name);
        if($status === false){
            throw new ImapClientException('Delete folder is failed');
        };
    }

    /**
     * Returns unseen emails in the current folder
     *
     * @param bool $read Mark message like SEEN or no. True -> SEEN, False -> UNSEEN
     * @return array objects IncomingMessage
     */
    public function getUnreadMessages($read = true) {
        $emails = [];
        $result = imap_search($this->stream, 'UNSEEN');
        if(!$result){
            #throw new ImapClientException('No read messages were found');
            return $emails;
        };
        $ids = ''; $countId = count($result);
        foreach($result as $key=>$id) {
            #$emails[]= $this->getMessage($id);
            $emails[] = $this->returnMessage($id, $this->getMessageConstant);
            if(($countId-1) == $key){
                $ids .= $id;
            }else{
                $ids .= $id.',';
            };
        }
        /* Set flag UNSEEN */
        if(!$read){
            $this->setUnseenMessage($ids);
        };
        return $emails;
    }

    /**
     * Delete flag message SEEN
     *
     * @param int $ids or string like 1,2,3,4,5 or string like 1:5
     * @return bool
     */
    public function setUnseenMessage($ids)
    {
        return imap_clearflag_full($this->stream, $ids, "\\Seen");
    }

    /**
     * Get messages in current folder
     *
     * @param int    $number of messages and 0 to get all
     * @param int    $start Starting message number
     * @param string $order ASC or DESC
     * @return array IncomingMessage of objects
     */
    public function getMessages($number = 0, $start = 0, $order = self::DESC)
    {
        if ($number == 0) {
            $number = $this->countMessages();
        };
        $emails = array();
        $result = imap_search($this->stream, 'ALL');
        if ($result) {
            $ids = array();
            foreach ($result as $k => $i) {
                $ids[] = $i;
            };
            if ($order == self::DESC) {
                $ids = array_reverse($ids);
            };
            $ids = array_chunk($ids, $number);
            $ids = $ids[$start];
            foreach ($ids as $id) {
                #$emails[] = $this->getMessage($id);
                $emails[] = $this->returnMessage($id, $this->getMessageConstant);
            };
        };
        return $emails;
    }

    /**
     * Get Messages by Criteria
     *
     * @see http://php.net/manual/en/function.imap-search.php
     * @param string $criteria ALL, UNSEEN, FLAGGED, UNANSWERED, DELETED, UNDELETED, etc (e.g. FROM "joey smith")
     * @param int    $number
     * @param int    $start
     * @param string $order
     * @return array
     * @throws ImapClientException
     */
    public function getMessagesByCriteria($criteria = '', $number = 0, $start = 0, $order = self::DESC)
    {
        $emails = array();
        $result = imap_search($this->stream, $criteria);
        if(!$result){
            throw new ImapClientException('Messages not found or this criteria not supported on your email server');
        };
        if ($number == 0) {
            $number = count($result);
        }
        if ($result) {
            $ids = array();
            foreach ($result as $k => $i) {
                $ids[] = $i;
            };
            $ids = array_chunk($ids, $number);
            $ids = array_slice($ids[0], $start, $number);
            $emails = array();
            foreach ($ids as $id) {
                #$emails[] = $this->getMessage($id);
                $emails[] = $this->returnMessage($id, $this->getMessageConstant);
            }
        }
        if ($order == self::DESC) {
            $emails = array_reverse($emails);
        }
        return $emails;
    }

    /**
     * Delete the given message
     *
     * @param int $id of the message
     * @return void
     */
    public function deleteMessage($id)
    {
        $this->deleteMessages(array($id));
    }

    /**
     * Delete messages
     *
     * @see http://php.net/manual/en/function.imap-delete.php
     * @see http://php.net/manual/en/function.imap-expunge.php
     * @param $ids array of ids
     * @return void
     */
    public function deleteMessages($ids)
    {
        foreach ($ids as $id) {
            imap_delete($this->stream, $id, $this->identifier);
        };
        imap_expunge($this->stream);
    }

    /**
     * @return void
     */
    public function deleteMessagesInCurrentFolder()
    {
        $ids = range(1, $this->countMessages());
        $this->deleteMessages($ids);
    }

    /**
     * Move given message in new folder
     *
     * @param int $id of the message in current folder
     * @param string $target new folder
     * @return void
     */
    public function moveMessage($id, $target)
    {
        $this->moveMessages(array($id), $target);
    }

    /**
     * Move given messages in new folder
     *
     * @param array $ids of message in current folder
     * @param string $target new folder
     * @return void
     * @throws ImapClientException
     */
    public function moveMessages($ids, $target)
    {
        $status = imap_mail_move($this->stream, implode(",", $ids), $target, $this->identifier);
        if($status === false){
            throw new ImapClientException('Move messages is failed');
        };
        imap_expunge($this->stream);
    }

    /**
     * @return void
     * @throws ImapClientException
     */
    public function subscribeToMailbox()
    {
        $status = imap_subscribe ($this->stream, $this->parameters->getMailboxString());
        if ($status === false) {
            throw new ImapClientException('Subscribe failed');
        };
    }

    /**
     * @return void
     * @throws ImapClientException
     */
    public function unsubscribeFromMailbox()
    {
        $status = imap_unsubscribe($this->stream, $this->parameters->getMailboxString());
        if ($status === false) {
            throw new ImapClientException('Unsubscribe failed');
        };
    }

    /**
     * Save Attachments Messages By Subject
     *
     * @param string $subject
     * @param string $dir for save attachments
     * @param string $charset for search
     * @return void
     * @throws ImapClientException
     */
    public function saveAttachmentsMessagesBySubject($subject, $dir = null, $charset = null)
    {
        $criteria = 'SUBJECT "'.$subject.'"';
        $ids = imap_search($this->stream, $criteria, null, $charset);
        if(!$ids){
            throw new ImapClientException('Messages not found or this criteria not supported on your email server');
        };
        foreach ($ids as $id) {
            $this->getMessageAttachments($id);
            if(isset($dir)){
                $dir = ['dir'=>$dir];
            };
            $this->saveAttachments($dir);
        };
    }

    /**
     * Create text message in folder
     *
     * @see http://php.net/manual/ru/function.imap-append.php
     * @param string $headers
     * @param string $message
     * @param string $folder like 'INBOX.Sent'
     * @return bool
     */
    public function createTextMessageInFolder($headers, $message, $folder) {
        return imap_append($this->stream, $this->parameters->getMailbox()->getServerPart() . $folder, $headers . "\r\n" . $message . "\r\n");
    }

    /**
     * Return general mailbox statistics
     *
     * @return object
     * @throws ImapClientException
     */
    public function getMailboxStatistics()
    {
        $object = imap_mailboxmsginfo($this->stream);
        if(!$object){
            throw new ImapClientException('GetMailboxStatistics failed');
        };
        return $object;
    }

    /**
     * Retrieve the quota level settings, and usage statics per mailbox.
     *
     * @see http://php.net/manual/en/function.imap-get-quota.php
     * @param string $userName
     * @return array
     * @throws ImapClientException
     */
    public function getQuota($userName)
    {
        $quota = imap_get_quota($this->stream, 'user.'.$userName);
        if(!$quota){
            throw new ImapClientException('GetQuota failed');
        };
        return $quota;
    }

    /**
     * Retrieve the quota level settings, and usage statics per mailbox.
     *
     * @see http://php.net/manual/en/function.imap-get-quotaroot.php
     * @param string $folder like 'INBOX'
     * @return array
     * @throws ImapClientException
     */
    public function getQuotaRoot($folder)
    {
        $quota = imap_get_quotaroot($this->stream, $folder);
        if(!$quota){
            throw new ImapClientException('GetQuotaRoot failed');
        };
        return $quota;
    }

    /**
     * Check message id
     *
     * @param integer $id
     * @return void
     * @throws ImapClientException
     */
    public function checkMessageId($id)
    {
        if(!is_int($id)){
            throw new ImapClientException('$id must be an integer!');
        };
        if($id <= 0){
            throw new ImapClientException('$id must be greater then 0!');
        };
        if($id > $this->countMessages()){
            throw new ImapClientException('$id does not exist');
        }
    }

    /**
     * Returns email addresses in the specified folder
     *
     * @param string $folder Specified folder
     * @return array addresses
     */
    public function getEmailAddressesInFolder($folder)
    {
        $saveCurrentFolder = $this->parameters->getMailbox()->getMailboxName();

        $this->selectFolder($folder);
        $emails = [];
        $countMessages = $this->countMessages();
        if($countMessages == 0) {
            return $emails;
        };
        $this->saveIdentifier();
        $this->useID();
        $range = '1:'.$countMessages;
        $arrayObject = ImapHelper::imapFetchOverview(new MessageIdentifier($this->stream, $range, $this->identifier));
        $this->restoreIdentifier();

        foreach($arrayObject as $messageHeadersObject) {
            $emails[] = $messageHeadersObject->from;
            $emails[] = $messageHeadersObject->to;
        };

        $this->selectFolder($saveCurrentFolder);
        return array_unique($emails);
    }

    /**
     * Returns all email addresses in all folders
     *
     * If you have a lot of folders and letters, it can take a long time.
     *
     * @param array|null $options have options:
     * ```php
     * $options['getFolders']['separator']
     * $options['getFolders']['type']
     * ```
     * @return array with all email addresses
     */
    public function getEmailAddressesInAllFolders(array $options = null)
    {
        /* Check Options */
        if(!isset($options['getFolders']['separator'])){
            $options['getFolders']['separator'] = '.';
        };
        if(!isset($options['getFolders']['type'])){
            $options['getFolders']['type'] = 1;
        };

        $saveCurrentFolder = $this->parameters->getMailbox()->getMailboxName();
        $emailsOut = [];
        $this->saveIdentifier();

        foreach($this->getFolders($options['getFolders']['separator'], $options['getFolders']['type']) as $folder) {
            $this->selectFolder($folder);
            $countMessages = $this->countMessages();
            if($countMessages == 0) {
                continue;
            };
            $range = '1:'.$countMessages;
            $arrayObject = ImapHelper::imapFetchOverview(new MessageIdentifier($this->stream, $range, $this->identifier));

            $emails = [];
            foreach($arrayObject as $messageHeadersObject) {
                $emails[] = $messageHeadersObject->from;
                $emails[] = $messageHeadersObject->to;
            };
            $emailsOut = array_merge($emailsOut, $emails);
        }
        $this->selectFolder($saveCurrentFolder);
        $this->restoreIdentifier();
        return array_unique($emailsOut);
    }

    /**
     * Saves the raw email into a file
     *
     * @param string $fileName
     * @param int $id
     * @return void
     * @throws ImapClientException
     */
    public function saveEmail($fileName, $id)
    {
        if(!is_string($fileName)) {
            throw new ImapClientException('File must be a string for saveEmail()');
        };
        if(!is_int($id)) {
            throw new ImapClientException('$id must be a integer for saveEmail()');
        };

        $statusOpenFile = $file = fopen($fileName,'w');
        $statusImapSaveBody = ImapHelper::imapSaveBody(
            new MessageIdentifier($this->stream, $id, $this->identifier),
            $file
            );
        $statusFclose = fclose($file);

        if($statusOpenFile === false){
            throw new ImapClientException('File is not open');
        };
        if($statusImapSaveBody === false){
            throw new ImapClientException('imap_savebody() failed');
        };
        if($statusFclose === false){
            throw new ImapClientException('File is not close');
        };
    }

    /**
     * Send an email
     *
     * @return void
     */
    public function sendMail()
    {
        $outMessage = new AdapterForOutgoingMessage($this->parameters);
        $outMessage->send();
    }

    /**
     * Register-dependent method
     *
     * @param string $nameFolder
     * @return bool
     */
    public function isFolder($nameFolder)
    {
        $folders = $this->getFolders(null, 1);
        foreach ($folders as $folder) {
            $pos = strpos($folder, $nameFolder);
            if($pos !== false){
                return true;
            };
        };
        return false;
    }

    /**
     * @param Message $message
     * @return bool
     */
    public function messageIsHtml(Message $message)
    {
        $parts = $message->getParts();
        foreach ($parts as $part) {
            if(stripos($part['subtype'], 'html') !== false){
                return true;
            }
        };
        return false;
    }

    /**
     * @param Message $message
     * @return bool
     */
    public function messageIsPlain(Message $message)
    {
        $parts = $message->getParts();
        foreach ($parts as $part) {
            if(stripos($part['subtype'], 'plain') !== false){
                return true;
            }
        };
        return false;
    }

    /**
     * @param Message $message
     * @param $subtype
     * @return string
     */
    public function whatMessagePartIs(Message $message, $subtype)
    {
        $parts = $message->getParts();
        foreach ($parts as $part) {
            if(stripos($part['subtype'], $subtype) !== false){
                return $part['part'];
            };
        };
        return '';
    }

    /**
     * @param array $parts
     * @param $subtype
     * @return string
     */
    public function whatPartIs(array $parts, $subtype)
    {
        foreach ($parts as $part) {
            if(stripos($part['subtype'], $subtype) !== false){
                return $part['part'];
            };
        };
        return '';
    }

    /**
     * @param Message $message
     * @throws ImapClientException
     */
    public function checkGetMessage($message)
    {
        $this->checkMessage($message);
        if(!is_null($message->getAttachments())){
            throw new ImapClientException('Property attachments in message object is not NULL');
        };
    }

    /**
     * @param Message $message
     * @throws ImapClientException
     */
    public function checkGetMessageWithAttachments($message)
    {
        $this->checkMessage($message);
        if(!is_array($message->getAttachments())){
            throw new ImapClientException('Property attachments in message object is not array');
        };
    }

    /**
     * @param Message $message
     * @throws ImapClientException
     */
    private function checkMessage($message)
    {
        if(!is_object($message)){
            throw new ImapClientException('Message is not object');
        };

        if(!property_exists($message, $property = 'headers')){
            throw new ImapClientException('Message object not exists property '.$property);
        };
        if(!is_object($message->getHeaders())){
            throw new ImapClientException('Property headers in message object is not object');
        };

        if(!property_exists($message, $property = 'parts')){
            throw new ImapClientException('Message object not exists property '.$property);
        };
        if(!is_array($message->getParts())){
            throw new ImapClientException('Property parts in message object is not array');
        };

        if(!property_exists($message, $property = 'body')){
            throw new ImapClientException('Message object not exists property '.$property);
        };
        if(!is_object($message->getBody())){
            throw new ImapClientException('Property body in message object is not object');
        };

        if(!property_exists($message, $property = 'attachments')){
            throw new ImapClientException('Message object not exists property '.$property);
        };
    }
/*
    private function returnMessage($id, $const = null)
    {
        switch ($const)
        {
            case self::STRUCTURE :
                return $this->getMessageStructure($id);
                break;
            case self::PARTS :
                return $this->getMessageParts($id);
                break;
            case self::HEADERS :
                return $this->getMessageHeaders($id);
                break;
            case self::SHORT_HEADERS :
                return $this->getMessageShortHeaders($id);
                break;
            case self::BODY :
                return $this->getMessageBody($id);
                break;
            case self::MESSAGE :
                return $this->getMessage($id);
                break;
            case self::MESSAGE_WITH_ATTACHMENTS :
                return $this->getMessageWithAttachments($id);
                break;
            case self::ATTACHMENTS :
                return $this->getMessageAttachments($id);
                break;
            default :
                return $this->getMessage($id);
                break;
        }
    }
*/
}