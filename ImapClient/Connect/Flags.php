<?php

namespace sergey144010\ImapClient\Connect;


class Flags implements FlagsInterface
{
    const SERVICE_IMAP = '/service=imap';
    const SERVICE_POP3 = '/service=pop3';
    const SERVICE_NNTP = '/service=nntp';
    const IMAP = '/imap';
    const POP3 = '/pop3';
    const NNTP = '/nntp';
    const SSL = '/ssl';
    const TLS = '/tls';
    const NOTLS = '/notls';
    const VALIDATE_CERT = '/validate-cert';
    const NOVALIDATE_CERT = '/novalidate-cert';
    const DEBUG = '/debug';
    const SECURE = '/secure';
    const NORSH = '/norsh';
    const READONLY = '/readonly';
    const ANONYMOUS = '/anonymous';

    private $flags;

    public function __construct()
    {
        if(func_num_args() != 0){
            $flags = func_get_args();
            foreach ($flags as $key => $flag) {
                $this->setFlag($flag);
            }
        };
    }

    public function setFlag($flag)
    {
        $this->flags .= $flag;
        return $this;
    }

    public function getFlags()
    {
        return $this->flags;
    }
}