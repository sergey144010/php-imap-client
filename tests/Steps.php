<?php

namespace sergey144010\ImapClient\Tests;


use sergey144010\ImapClient\ImapClient;
use sergey144010\ImapClient\ImapClientException;
#use sergey144010\ImapClient\Tests\MessagesPool;
#use sergey144010\ImapClient\Tests\SimpleMessage;

class Steps
{
    /**
     * @var ImapClient
     */
    private $imapClient;
    private $testFolder;

    /**
     * Steps constructor.
     * @param $imapClient
     * @param $testFolder
     */
    public function __construct($imapClient, $testFolder)
    {
        $this->imapClient = $imapClient;
        $this->testFolder = $testFolder;
    }

    public function step2_check_sendAndDeleteMessage()
    {
        echo 'Start step 2'.PHP_EOL;
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step 2.1 countMessages() failed');
        };
        echo 'Set messages'. PHP_EOL;
        MessagesPool::push(new SimpleMessage());
        MessagesPool::push(new SimpleMessage());
        MessagesPool::push(new SimpleMessage());
        MessagesPool::send(
            $this->imapClient->getStream(),
            $this->imapClient->getConnectParameters()->getMailbox()->getServerPart().$this->testFolder);
        MessagesPool::clean();
        echo 'Messages send'. PHP_EOL;
        if($this->imapClient->countMessages() != 3){
            throw new ImapClientException('Step 2.2 countMessages() failed');
        };
        $this->imapClient->deleteMessagesInCurrentFolder();
        echo 'Messages delete'. PHP_EOL;
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step 2.3 countMessages() failed');
        };
    }

    public function step3_check_getMessageStructure()
    {
        echo 'Start step 3'.PHP_EOL;
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step 3.1 countMessages() failed');
        };
        echo 'Set messages'. PHP_EOL;
        MessagesPool::push(new SimpleMessage());
        MessagesPool::send(
            $this->imapClient->getStream(),
            $this->imapClient->getConnectParameters()->getMailbox()->getServerPart().$this->testFolder);
        MessagesPool::clean();
        echo 'Messages send'. PHP_EOL;

        $structure = $this->imapClient->getMessageStructure(1);
        if(!is_object($structure)){
            throw new ImapClientException('Step 3.2 getMessageStructure() return no object');
        };
        if(!property_exists($structure, 'subtype')){
            throw new ImapClientException('Step 4.3 structure object not exists property subtype');
        };
        if(!property_exists($structure, 'type')){
            throw new ImapClientException('Step 4.3 structure object not exists property type');
        };
        if(!property_exists($structure, 'encoding')){
            throw new ImapClientException('Step 4.3 structure object not exists property encoding');
        };

        $this->imapClient->deleteMessagesInCurrentFolder();
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step 3.3 countMessages() failed');
        };
    }

    public function step4_check_getMessageHeaders()
    {
        echo 'Start step 4'.PHP_EOL;
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step 4.1 countMessages() failed');
        };
        echo 'Set messages'. PHP_EOL;
        MessagesPool::push(new SimpleMessage());
        MessagesPool::send(
            $this->imapClient->getStream(),
            $this->imapClient->getConnectParameters()->getMailbox()->getServerPart().$this->testFolder);
        MessagesPool::clean();
        echo 'Messages send'. PHP_EOL;

        $headers = $this->imapClient->getMessageHeaders(1);
        if(!is_object($headers)){
            throw new ImapClientException('Step 4.2 getMessageHeaders() return no object');
        };
        if(!property_exists($headers, 'subject')){
            throw new ImapClientException('Step 4.3 headers object not exists property subject');
        };
        if(!property_exists($headers, 'from')){
            throw new ImapClientException('Step 4.4 headers object not exists property from');
        };
        if(!property_exists($headers, 'to')){
            throw new ImapClientException('Step 4.5 headers object not exists property to');
        };

        $this->imapClient->deleteMessagesInCurrentFolder();
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step 4.6 countMessages() failed');
        };
    }

    public function step5_check_getMessageShortHeaders()
    {
        $stepID = 5; $i = 1;
        echo 'Start step '.$stepID.PHP_EOL;
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
        echo 'Set messages'. PHP_EOL;
        MessagesPool::push(new SimpleMessage());
        MessagesPool::send(
            $this->imapClient->getStream(),
            $this->imapClient->getConnectParameters()->getMailbox()->getServerPart().$this->testFolder);
        MessagesPool::clean();
        echo 'Messages send'. PHP_EOL;

        $shotHeaders = $this->imapClient->getMessageShortHeaders(1);
        if(!is_object($shotHeaders)){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' getMessageHeaders() return no object');
        }; $i++;
        if(!property_exists($shotHeaders, $property = 'subject')){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        }; $i++;
        if(!property_exists($shotHeaders, $property = 'from')){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        }; $i++;
        if(!property_exists($shotHeaders, $property = 'to')){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        }; $i++;
        if(!property_exists($shotHeaders, $property = 'date')){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        }; $i++;
        if(!property_exists($shotHeaders, $property = 'size')){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        }; $i++;
        if(!property_exists($shotHeaders, $property = 'uid')){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        };
        if(!property_exists($shotHeaders, $property = 'msgno')){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        }; $i++;
        if(!property_exists($shotHeaders, $property = 'udate')){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        }; $i++;

        $this->imapClient->deleteMessagesInCurrentFolder();
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
    }

    public function step6_check_getMessageParts()
    {
        $stepID = 6; $i = 1;
        echo 'Start step '.$stepID.PHP_EOL;
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
        echo 'Set messages'. PHP_EOL;
        MessagesPool::push(new SimpleMessage());
        MessagesPool::send(
            $this->imapClient->getStream(),
            $this->imapClient->getConnectParameters()->getMailbox()->getServerPart().$this->testFolder);
        MessagesPool::clean();
        echo 'Messages send'. PHP_EOL;

        $parts = $this->imapClient->getMessageParts(1);
        if(!is_array($parts)){
            $this->imapClient->deleteMessagesInCurrentFolder();
            throw new ImapClientException('Step '.$stepID.'.'.$i.' getMessageParts() return no array');
        }; $i++;
        if($parts[0]['subtype'] != 'PLAIN'){
            $this->imapClient->deleteMessagesInCurrentFolder();
            throw new ImapClientException('Step '.$stepID.'.'.$i.' part is not PLAIN');
        }; $i++;

        $this->imapClient->deleteMessagesInCurrentFolder();
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
    }

    public function step7_check_getMessageBody()
    {
        $stepID = 7; $i = 1;
        echo 'Start step '.$stepID.PHP_EOL;
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
        echo 'Set messages'. PHP_EOL;
        MessagesPool::push(new SimpleMessage());
        MessagesPool::send(
            $this->imapClient->getStream(),
            $this->imapClient->getConnectParameters()->getMailbox()->getServerPart().$this->testFolder);
        MessagesPool::clean();
        echo 'Messages send'. PHP_EOL;

        $body = $this->imapClient->getMessageBody(1);
        if(!is_object($body)){
            $this->imapClient->deleteMessagesInCurrentFolder();
            throw new ImapClientException('Step '.$stepID.'.'.$i.' getMessageParts() return no object');
        }; $i++;
        if(!property_exists($body, $property = 'types')){
            $this->imapClient->deleteMessagesInCurrentFolder();
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        }; $i++;
        if(!property_exists($body, $property = 'plain')){
            $this->imapClient->deleteMessagesInCurrentFolder();
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        }; $i++;
        if(!property_exists($body, $property = 'text')){
            $this->imapClient->deleteMessagesInCurrentFolder();
            throw new ImapClientException('Step '.$stepID.'.'.$i.' headers object not exists property '.$property);
        }; $i++;

        $this->imapClient->deleteMessagesInCurrentFolder();
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
    }

    public function step8_check_getMessage()
    {
        $stepID = 8; $i = 1;
        echo 'Start step '.$stepID.PHP_EOL;
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
        echo 'Set messages'. PHP_EOL;
        MessagesPool::push(new SimpleMessage());
        MessagesPool::send(
            $this->imapClient->getStream(),
            $this->imapClient->getConnectParameters()->getMailbox()->getServerPart().$this->testFolder);
        MessagesPool::clean();
        echo 'Messages send'. PHP_EOL;

        $message = $this->imapClient->getMessage(1);
        try{
            $this->imapClient->checkGetMessage($message);
        }catch (ImapClientException $e){
            $this->imapClient->deleteMessagesInCurrentFolder();
            throw new ImapClientException('Step '.$stepID.' checkGetMessage() failed');
        };

        $this->imapClient->deleteMessagesInCurrentFolder();
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
    }

    public function step9_check_Inline()
    {
        /* HEADER */
        $stepID = 9; $i = 1;
        echo 'Start step '.$stepID.PHP_EOL;
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
        echo 'Set messages'. PHP_EOL;
        MessagesPool::push(LoadMessage::instance()->loadFile('emails/inline.eml'));
        MessagesPool::send(
            $this->imapClient->getStream(),
            $this->imapClient->getConnectParameters()->getMailbox()->getServerPart().$this->testFolder);
        MessagesPool::clean();
        echo 'Messages send'. PHP_EOL;

        /* WORK PART */
        $message = $this->imapClient->getMessageWithAttachments(1);
        try{
            $attachments = $message->getAttachments();
            if(!empty($attachments)){
                $this->imapClient->deleteMessagesInCurrentFolder();
                throw new ImapClientException('Error: Inline in attachments');
            };
        }catch (ImapClientException $e){
            $this->imapClient->deleteMessagesInCurrentFolder();
            throw new ImapClientException('Step '.$stepID.' failed');
        };

        /* FOOTER */
        $this->imapClient->deleteMessagesInCurrentFolder();
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
    }

    public function step10_check_onInlineInAttachments()
    {
        /* HEADER */
        $stepID = 10; $i = 1;
        echo 'Start step '.$stepID.PHP_EOL;
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
        echo 'Set messages'. PHP_EOL;
        MessagesPool::push(LoadMessage::instance()->loadFile('emails/inline.eml'));
        MessagesPool::send(
            $this->imapClient->getStream(),
            $this->imapClient->getConnectParameters()->getMailbox()->getServerPart().$this->testFolder);
        MessagesPool::clean();
        echo 'Messages send'. PHP_EOL;

        /* WORK PART */
        $this->imapClient->onInlineInAttachments();
        $message = $this->imapClient->getMessageWithAttachments(1);
        try{
            $attachments = $message->getAttachments();
            if(empty($attachments)){
                $this->imapClient->deleteMessagesInCurrentFolder();
                throw new ImapClientException('Error: Attachments do not contain inline');
            };
        }catch (ImapClientException $e){
            $this->imapClient->deleteMessagesInCurrentFolder();
            throw new ImapClientException('Step '.$stepID.' failed');
        };

        /* FOOTER */
        $this->imapClient->deleteMessagesInCurrentFolder();
        if($this->imapClient->countMessages() != 0){
            throw new ImapClientException('Step '.$stepID.'.'.$i.' countMessages() failed');
        }; $i++;
    }

}