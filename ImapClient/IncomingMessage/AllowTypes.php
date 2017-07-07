<?php

namespace sergey144010\ImapClient\IncomingMessage;

use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\Part;

class AllowTypes
{
    const PART_ATTACHMENTS = 1;
    const PART_BODY = 2;

    private $structure;
    private $parts;

    public function __construct($structure, $parts)
    {
        $this->structure = $structure;
        $this->parts = $parts;
    }

    public function getParts($type = null)
    {
        if (!$type) {
            return $this->parts;
        };
        $types = null;
        switch ($type) {
            case self::PART_ATTACHMENTS:
                $types = TypeAttachments::get();
                break;
            case self::PART_BODY:
                $types = TypeBody::get();
                break;
            default:
                throw new ImapClientException("Part type not recognised/supported");
                break;
        };
        $parts = [];
        foreach ($this->parts as $part) {
            $obj = Part::instance()->getPieceStructure($this->structure, $part['part']);
            if (!isset($obj->subtype)) {
                continue;
            };
            if (in_array($obj->subtype, $types, false)) {
                $parts[] = $part;
            };
        };
        return $parts;
    }
}