<?php

namespace sergey144010\ImapClient\Tests;

ini_set('display_errors', 'On'); //
error_reporting(E_ALL); // E_ALL -

require_once "../autoload.php";

use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\Connect\Parameters;
use sergey144010\ImapClient\Connect\ImapConnect;
use sergey144010\ImapClient\ImapClient;


#use SSilence\ImapClient\ImapClientSimple as Simple;

include ('config.php');

$testFolder = 'TestForImapClient';
try{
    /**
     * @var Parameters $parameters
     */
    $imapClient = new ImapClient(new ImapConnect($parameters));
    $steps = new Steps($imapClient, $testFolder);

    /*
     * Step 1
     */
    echo 'Start step 1'.PHP_EOL;
    if(!$imapClient->isFolder($testFolder)){
        echo 'Folder '.$testFolder.' not exist'. PHP_EOL;
        $imapClient->addFolder($testFolder);
    }else{
        echo 'Folder '.$testFolder.' exist'. PHP_EOL;
    };
    $imapClient->selectFolder($testFolder);

    #$imapClient->deleteMessagesInCurrentFolder();

    if(!$imapClient->currentFolderIsEmpty()){
        throw new ImapClientException('Folder '.$testFolder.' not empty');
    };

    $steps->step2_check_sendAndDeleteMessage();
    $steps->step3_check_getMessageStructure();
    $steps->step4_check_getMessageHeaders();
    $steps->step5_check_getMessageShortHeaders();
    $steps->step6_check_getMessageParts();
    $steps->step7_check_getMessageBody();
    $steps->step8_check_getMessage();

}catch(ImapClientException $e){
    echo $e->getMessage();
};