<?php

namespace sergey144010\ImapClient\IncomingMessage;


use sergey144010\ImapClient\IncomingMessage\Interfaces\TypeInterface;

class TypeAttachments implements TypeInterface
{
	/**
	 * Types of attachments
     *
     * @var array
	 */
    private $types = ['JPEG', 'PNG', 'GIF', 'PDF', 'X-MPEG', 'MSWORD', 'OCTET-STREAM', 'ZIP', 'PLAIN'];

	 /**
     * Get the allowed types.
     *
     * @return array
     */
    public function getList()
    {
        return $this->types;
    }

    /**
     * @param $structure
     * @param $subtype
     * @return bool|null
     */
    public function validate($structure, $subtype)
    {
        switch ($subtype){
            case 'PLAIN':
                return $this->validatePlain($structure);
                break;
        };
        return null;
    }

    /**
     * @param $structure
     * @return bool
     */
    private function validatePlain($structure)
    {
        if($structure->subtype == 'PLAIN'){
            if($structure->ifdisposition == 1){
                if($structure->disposition == 'attachment'){
                    return true;
                };
            };
        };
        return false;
    }
}
