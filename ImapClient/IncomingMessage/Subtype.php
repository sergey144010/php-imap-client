<?php

namespace sergey144010\ImapClient\IncomingMessage;


#use sergey144010\ImapClient\ImapClientException;

class Subtype implements \JsonSerializable
{
    private $body;
    private $charset;
    private $structure;


    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    public function setStructure($structure)
    {
        $this->structure = $structure;
    }

    public function getStructure()
    {
        return $this->structure;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getCharset()
    {
        return $this->charset;
    }

    /*
    public function __set($property, $value)
    {
        switch($property)
        {
            case 'charset':
                $this->charset = $value;
                break;
            case 'body':
                $this->body = $value;
                break;
            case 'structure':
                $this->structure = $value;
                break;
            default:
                throw new ImapClientException('Subtype object have only "charset", "body" ,"structure" properties');
        };
    }

    public function __get($property)
    {
        switch($property)
        {
            case 'charset':
                return $this->charset;
                break;
            case 'body':
                return $this->body;
                break;
            case 'structure':
                return $this->structure;
                break;
            default:
                throw new ImapClientException('Subtype object have only "charset", "body", "structure" properties');
        }
    }

    public function __isset($property)
    {
        switch($property)
        {
            case 'charset':
                return $this->charset;
                break;
            case 'body':
                return $this->body;
                break;
            case 'structure':
                return $this->structure;
                break;
            default:
                throw new ImapClientException('Subtype object have only "charset", "body", "structure" properties');
        }
    }

    public function __unset($property)
    {
        throw new ImapClientException('Subtype object not supported unset');
    }
*/

    public function __toString()
    {
        if(!$this->body){
            return '';
        };
        return $this->body;
    }

    public function jsonSerialize()
    {
        $properties = get_object_vars($this);
        $outProperties = [];
        foreach ($properties as $property => $value) {
                $outProperties[$property] = $this->$property;
        };
        return $outProperties;
    }
}
