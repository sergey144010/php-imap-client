<?php

namespace sergey144010\ImapClient\IncomingMessage;


use sergey144010\ImapClient\IncomingMessage\Interfaces\TypeInterface;

class TypeAttachments implements TypeInterface
{

    const ON_INLINE_VALIDATE = 0;
    const OFF_INLINE_VALIDATE = 1;

    private static $validate;

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

    public static function offInlineValidate()
    {
        self::$validate = self::OFF_INLINE_VALIDATE;
    }

    public static function onInlineValidate()
    {
        self::$validate = self::ON_INLINE_VALIDATE;
    }

    /**
     * @param $structure
     * @param $subtype
     * @return bool
     */
    public function validate($structure, $subtype)
    {
        if(self::$validate == self::ON_INLINE_VALIDATE){
            switch ($subtype){
                case 'PLAIN':
                    return $this->validatePlain($structure);
                    break;

                /* INLINE Validation */
                case 'JPEG':
                    return $this->validateInline($structure);
                    break;
                case 'PNG':
                    return $this->validateInline($structure);
                    break;
                case 'GIF':
                    return $this->validateInline($structure);
                    break;
            };
        }else{
            switch ($subtype){
                case 'PLAIN':
                    return $this->validatePlain($structure);
                    break;
            };
        };
        return true;
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

    private function validateInline($structure)
    {
            if($structure->ifdisposition == 1){
                if($structure->disposition == 'inline'){
                    return false;
                };
            };
        return true;
    }
}
