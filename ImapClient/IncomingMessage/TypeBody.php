<?php

namespace sergey144010\ImapClient\IncomingMessage;


use sergey144010\ImapClient\IncomingMessage\Interfaces\TypeInterface;

class TypeBody implements TypeInterface
{
	/**
	 * Types of body's
     *
     * @var array
	 */
    private $types = ['PLAIN', 'HTML'];

    /**
     * Get the allowed types.
     *
     * @return array
     */
    public function getList()
    {
        return$this->types;
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
                    return false;
                };
            };
        };
        return true;
    }
}
