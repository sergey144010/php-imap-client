<?php
/**
 * Created by PhpStorm.
 * User: Sergey144010
 * Date: 06.05.2017
 * Time: 19:09
 */

namespace sergey144010\ImapClient;


class ImapHelper
{
    /**
     * Fetch a particular section of the body of the message
     *
     * Wrapper for imap_fetchbody()
     * @see http://php.net/manual/en/function.imap-fetchbody.php
     * @param MessageIdentifierInterface $identifier
     * @param string $section of the body of the specified messages
     * @return string
     */
    public static function imapFetchBody(MessageIdentifierInterface $identifier, $section)
    {
        return imap_fetchbody($identifier->getStream(), $identifier->getId(), $section, $identifier->getIdentifier());
    }

    /**
     * Read the structure of a particular message
     *
     * Wrapper for imap_fetchstructure()
     * @see http://php.net/manual/en/function.imap-fetchstructure.php
     * @param MessageIdentifierInterface $identifier
     * @return object
     */
    public static function imapFetchStructure(MessageIdentifierInterface $identifier)
    {
        return imap_fetchstructure($identifier->getStream(), $identifier->getId(), $identifier->getIdentifier());
    }

    /**
     * Read the structure of a specified body section of a specific message
     *
     * Wrapper for imap_bodystruct()
     * @see http://php.net/manual/en/function.imap-bodystruct.php
     * @param MessageIdentifierInterface $identifier
     * @param string $section of the body of the specified messages
     * @return object
     */
    public static function imapBodyStruct(MessageIdentifierInterface $identifier, $section)
    {
        $id = $identifier->getId();
        if($identifier->getIdentifier() === FT_UID){
            $id = self::getID($identifier);
        };
        return imap_bodystruct($identifier->getStream(), $id, $section);
    }

    /**
     * Read an overview of the information in the headers of the given message
     *
     * Wrapper for php imap_fetch_overview()
     * @see http://php.net/manual/en/function.imap-fetch-overview.php
     *
     * Param string $identifier->getId() a message sequence description,
     * you can enumerate desired messages with the X,Y syntax,
     * or retrieve all messages within an interval with the X:Y syntax
     *
     * Param int $identifier->getIdentifier() sequence will contain a sequence of message indices or UIDs,
     * if this parameter is set to FT_UID.
     *
     * @param MessageIdentifierInterface $identifier
     * @return array
     */
    public static function imapFetchOverview(MessageIdentifierInterface $identifier)
    {
        return imap_fetch_overview($identifier->getStream(), $identifier->getId(), $identifier->getIdentifier());
    }

    /**
     * Read the header of the message
     *
     * Wrapper for php imap_headerinfo()
     * @see http://php.net/manual/en/function.imap-headerinfo.php
     * @param MessageIdentifierInterface $identifier
     * @return object|false
     */
    public static function imapHeaderInfo(MessageIdentifierInterface $identifier)
    {
        $id = $identifier->getId();
        if($identifier->getIdentifier() === FT_UID){
            $id = self::getID($identifier);
        };
        return imap_headerinfo($identifier->getStream(), $id);
    }

    /**
     * Decode MIME header elements
     *
     * Wrapper for imap_mime_header_decode()
     * @see http://php.net/manual/en/function.imap-mime-header-decode.php
     * @param string $string
     * @return array
     */
    public static function imapMimeHeaderDecode($string)
    {
        return imap_mime_header_decode($string);
    }

    /**
     * Gets the message sequence number for the given UID
     *
     * Wrapper for imap_msgno()
     * @see http://php.net/manual/en/function.imap-msgno.php
     * @param MessageIdentifierInterface $identifier
     * @return int
     */
    public static function getID(MessageIdentifierInterface $identifier)
    {
        return imap_msgno($identifier->getStream(), $identifier->getId());
    }

    /**
     * This function returns the UID for the given message sequence number
     *
     * Wrapper for imap_uid()
     * @see http://php.net/manual/en/function.imap-uid.php
     * @param MessageIdentifierInterface $identifier
     * @return int
     */
    public static function getUID(MessageIdentifierInterface $identifier)
    {
        return imap_uid($identifier->getStream(), $identifier->getId());
    }

    /**
     * @see http://php.net/manual/en/function.imap-savebody.php
     * @param MessageIdentifierInterface $identifier
     * @param string $fileName
     * @param null $part
     * @return bool
     */
    public static function imapSaveBody(MessageIdentifierInterface $identifier, $fileName, $part = null)
    {
        return imap_savebody($identifier->getStream(), $fileName, $identifier->getId(), $part, $identifier->getIdentifier());
    }
}