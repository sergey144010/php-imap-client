<?php
# this is draft
namespace sergey144010\ImapClient;

interface ImapClientInterface
{
    public function useID();
    public function useUID();
    
    public function getMessage($id, string $type);
    public function moveMessage($id, $target)
    public function deleteMessage($id);
    
    public function selectFolder($name);
    public function addFolder($name);
    public function renameFolder($currentName, $newName);
    public function deleteFolder($name);
}
