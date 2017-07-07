<?php

namespace sergey144010\ImapClient;


class Part
{
    public static function pullBody(MessageIdentifierInterface $identifier, $part)
    {
        if($part == 0){
            /*
            If the message id is correct and the structure is returned,
            then there is exactly one section in the message.
            */
            return ImapHelper::imapFetchbody($identifier, 1);
        }else{
            return ImapHelper::imapFetchbody($identifier, $part);
        }
    }

    public static function pullStructure(MessageIdentifierInterface $identifier, $part)
    {
        return ImapHelper::imapBodyStruct($identifier, $part);
    }

    public static function instance()
    {
        return new self();
    }

    public function getPieceStructure($structure, $part)
    {
        return $this->getPieceStructureFromIncomingStructure($structure, $part);
    }

    /**
     * @param object $structure
     * @param string $part - example string -> 1, 1.1, 2, 2.1, 2.5
     * @return object|null
     */
    public function getPieceStructureFromIncomingStructure($structure, $part)
    {
        $section = $part;
        $pos = strpos($section, '.');
        if($pos === false){
            $section = (int)$section;
            if($section == 0){
                return $structure;
            };
            return $structure->parts[($section-1)];
        };
        $sections = explode('.', $section);
        #$count = count($sections);
        $outObject = null;
        foreach ($sections as $section) {
            $section = (int)$section;
            if(!isset($outObject)){
                $outObject = $this->getObjectStructureFromParts($structure, ($section-1));
            }else{
                $outObject = $this->getObjectStructureFromParts($outObject, ($section-1));
            };
        };
        return $outObject;
    }

    private function getObjectStructureFromParts($inObject, $part)
    {
        return $inObject->parts[$part];
    }
}