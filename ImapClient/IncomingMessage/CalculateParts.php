<?php

namespace sergey144010\ImapClient\IncomingMessage;


class CalculateParts
{
    private $structure;
    private $section;

    public function __construct($structure)
    {
        $this->structure = $structure;
        $this->getCountSection();
    }

    public function getParts()
    {
        return $this->section;
    }

    /**
     * Get count section
     *
     * We take $this->section and make a simple array from an array of arrays.
     * If getRecursiveSections($this->structure) set $this->section to NULL,
     * then we think that there is only one section in the letter.
     * We install $this->section[0] = [0],
     * and then we will take this into account in subsequent processing.
     * Namely here getSection() and $this->getSectionStructure()
     * or getSectionStructureFromIncomingStructure().
     * Because if the message id is correct and the structure is returned,
     * then there is exactly one section in the message.
     *
     * @return void
     */
    private function getCountSection()
    {
        $this->getRecursiveSections($this->structure);
        $sections = [];
        if(!isset($this->section)){
            $this->section[0] = [['part' => (string)'0', 'subtype' => $this->structure->subtype]];
        };
        foreach ($this->section as $array) {
            foreach ($array as $section) {
                $sections[] = $section;
            };
        };
        #$sections = array_unique($sections);
        sort($sections);
        $this->section = $sections;
    }

    /**
     * Bypasses the recursive parts current message
     *
     * Counts sections based on $obj->parts.
     * And sets $this->section as an array of arrays or null.
     * Null if $obj->parts is not.
     *
     * @param object $obj
     * @param string $before
     * @return void
     */
    private function getRecursiveSections($obj, $before = null)
    {
        if(!isset($obj->parts)){
            return;
        };
        #$countParts = count($obj->parts);
        $out = [];
        $beforeSave = $before;
        foreach ($obj->parts as $key => $subObj) {
            if(!isset($beforeSave)){
                $before = ($key+1);
            }else{
                $before = $beforeSave.'.'.($key+1);
            };
            $this->getRecursiveSections($subObj, $before);
            $out[] = ['part' => (string)$before, 'subtype' => $subObj->subtype];
        };
        $this->section[] = $out;
    }
}