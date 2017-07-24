# Example var_dump() incoming message obtained through getMessageWithAttachments()

```php
object(sergey144010\ImapClient\IncomingMessage\Message)#30 (4) {
  ["headers":"sergey144010\ImapClient\IncomingMessage\Message":private]=>
  object(stdClass)#26 (21) {
    ["date"]=>
    string(31) "Mon, 24 Jul 2017 06:49:50 +0000"
    ["Date"]=>
    string(31) "Mon, 24 Jul 2017 06:49:50 +0000"
    ["subject"]=>
    string(17) "Test-TEXT-CSV-ZIP"
    ["Subject"]=>
    string(17) "Test-TEXT-CSV-ZIP"
    ["message_id"]=>
    string(38) "<1499504516.552972723@f462.i.mails.ru>"
    ["toaddress"]=>
    string(37) "Sergey Ivanov <sergey144010@mails.ru>"
    ["to"]=>
    array(1) {
      [0]=>
      object(stdClass)#27 (3) {
        ["personal"]=>
        string(13) "Sergey Ivanov"
        ["mailbox"]=>
        string(12) "sergey144010"
        ["host"]=>
        string(8) "mails.ru"
      }
    }
    ["fromaddress"]=>
    string(37) "Sergey Ivanov <sergey144010@mails.ru>"
    ["from"]=>
    array(1) {
      [0]=>
      object(stdClass)#28 (3) {
        ["personal"]=>
        string(13) "Sergey Ivanov"
        ["mailbox"]=>
        string(12) "sergey144010"
        ["host"]=>
        string(8) "mails.ru"
      }
    }
    ["reply_toaddress"]=>
    string(56) "=?UTF-8?B?U2VyZ2V5IEl2YW5vdg==?= <sergey144010@mails.ru>"
    ["reply_to"]=>
    array(1) {
      [0]=>
      object(stdClass)#29 (3) {
        ["personal"]=>
        string(32) "=?UTF-8?B?U2VyZ2V5IEl2YW5vdg==?="
        ["mailbox"]=>
        string(12) "sergey144010"
        ["host"]=>
        string(8) "mails.ru"
      }
    }
    ["Recent"]=>
    string(1) " "
    ["Unseen"]=>
    string(1) "U"
    ["Flagged"]=>
    string(1) " "
    ["Answered"]=>
    string(1) " "
    ["Deleted"]=>
    string(1) " "
    ["Draft"]=>
    string(1) " "
    ["Msgno"]=>
    string(4) "   1"
    ["MailDate"]=>
    string(26) "24-Jul-2017 06:49:50 +0000"
    ["Size"]=>
    string(4) "3082"
    ["udate"]=>
    int(1500878990)
  }
  ["parts":"sergey144010\ImapClient\IncomingMessage\Message":private]=>
  array(6) {
    [0]=>
    array(3) {
      ["part"]=>
      string(1) "1"
      ["subtype"]=>
      string(11) "ALTERNATIVE"
      ["disposition"]=>
      string(0) ""
    }
    [1]=>
    array(3) {
      ["part"]=>
      string(3) "1.1"
      ["subtype"]=>
      string(5) "PLAIN"
      ["disposition"]=>
      string(0) ""
    }
    [2]=>
    array(3) {
      ["part"]=>
      string(3) "1.2"
      ["subtype"]=>
      string(4) "HTML"
      ["disposition"]=>
      string(0) ""
    }
    [3]=>
    array(3) {
      ["part"]=>
      string(1) "2"
      ["subtype"]=>
      string(12) "OCTET-STREAM"
      ["disposition"]=>
      string(10) "attachment"
    }
    [4]=>
    array(3) {
      ["part"]=>
      string(1) "3"
      ["subtype"]=>
      string(5) "PLAIN"
      ["disposition"]=>
      string(10) "attachment"
    }
    [5]=>
    array(3) {
      ["part"]=>
      string(1) "4"
      ["subtype"]=>
      string(3) "ZIP"
      ["disposition"]=>
      string(10) "attachment"
    }
  }
  ["body":"sergey144010\ImapClient\IncomingMessage\Message":private]=>
  object(stdClass)#31 (4) {
    ["types"]=>
    array(3) {
      [0]=>
      string(5) "plain"
      [1]=>
      string(4) "html"
      [2]=>
      string(4) "text"
    }
    ["plain"]=>
    object(sergey144010\ImapClient\IncomingMessage\Subtype)#34 (3) {
      ["body":"sergey144010\ImapClient\IncomingMessage\Subtype":private]=>
      bool(false)
      ["charset":"sergey144010\ImapClient\IncomingMessage\Subtype":private]=>
      string(5) "utf-8"
      ["structure":"sergey144010\ImapClient\IncomingMessage\Subtype":private]=>
      object(stdClass)#12 (11) {
        ["type"]=>
        int(0)
        ["encoding"]=>
        int(3)
        ["ifsubtype"]=>
        int(1)
        ["subtype"]=>
        string(5) "PLAIN"
        ["ifdescription"]=>
        int(0)
        ["ifid"]=>
        int(0)
        ["bytes"]=>
        int(24)
        ["ifdisposition"]=>
        int(0)
        ["ifdparameters"]=>
        int(0)
        ["ifparameters"]=>
        int(1)
        ["parameters"]=>
        array(1) {
          [0]=>
          object(stdClass)#13 (2) {
            ["attribute"]=>
            string(7) "charset"
            ["value"]=>
            string(5) "utf-8"
          }
        }
      }
    }
    ["html"]=>
    object(sergey144010\ImapClient\IncomingMessage\Subtype)#35 (3) {
      ["body":"sergey144010\ImapClient\IncomingMessage\Subtype":private]=>
      string(57) "
<HTML><BODY>Test-TEXT-CSV-ZIP<br><br><br></BODY></HTML>
"
      ["charset":"sergey144010\ImapClient\IncomingMessage\Subtype":private]=>
      string(5) "utf-8"
      ["structure":"sergey144010\ImapClient\IncomingMessage\Subtype":private]=>
      object(stdClass)#14 (11) {
        ["type"]=>
        int(0)
        ["encoding"]=>
        int(3)
        ["ifsubtype"]=>
        int(1)
        ["subtype"]=>
        string(4) "HTML"
        ["ifdescription"]=>
        int(0)
        ["ifid"]=>
        int(0)
        ["bytes"]=>
        int(76)
        ["ifdisposition"]=>
        int(0)
        ["ifdparameters"]=>
        int(0)
        ["ifparameters"]=>
        int(1)
        ["parameters"]=>
        array(1) {
          [0]=>
          object(stdClass)#15 (2) {
            ["attribute"]=>
            string(7) "charset"
            ["value"]=>
            string(5) "utf-8"
          }
        }
      }
    }
    ["text"]=>
    object(sergey144010\ImapClient\IncomingMessage\Subtype)#34 (3) {
      ["body":"sergey144010\ImapClient\IncomingMessage\Subtype":private]=>
      bool(false)
      ["charset":"sergey144010\ImapClient\IncomingMessage\Subtype":private]=>
      string(5) "utf-8"
      ["structure":"sergey144010\ImapClient\IncomingMessage\Subtype":private]=>
      object(stdClass)#12 (11) {
        ["type"]=>
        int(0)
        ["encoding"]=>
        int(3)
        ["ifsubtype"]=>
        int(1)
        ["subtype"]=>
        string(5) "PLAIN"
        ["ifdescription"]=>
        int(0)
        ["ifid"]=>
        int(0)
        ["bytes"]=>
        int(24)
        ["ifdisposition"]=>
        int(0)
        ["ifdparameters"]=>
        int(0)
        ["ifparameters"]=>
        int(1)
        ["parameters"]=>
        array(1) {
          [0]=>
          object(stdClass)#13 (2) {
            ["attribute"]=>
            string(7) "charset"
            ["value"]=>
            string(5) "utf-8"
          }
        }
      }
    }
  }
  ["attachments":"sergey144010\ImapClient\IncomingMessage\Message":private]=>
  array(3) {
    [0]=>
    object(stdClass)#36 (3) {
      ["name"]=>
      string(11) "FileCSV.csv"
      ["body"]=>
      string(8) "File CSZ"
      ["structure"]=>
      object(stdClass)#16 (13) {
        ["type"]=>
        int(3)
        ["encoding"]=>
        int(3)
        ["ifsubtype"]=>
        int(1)
        ["subtype"]=>
        string(12) "OCTET-STREAM"
        ["ifdescription"]=>
        int(0)
        ["ifid"]=>
        int(0)
        ["bytes"]=>
        int(8)
        ["ifdisposition"]=>
        int(1)
        ["disposition"]=>
        string(10) "attachment"
        ["ifdparameters"]=>
        int(1)
        ["dparameters"]=>
        array(1) {
          [0]=>
          object(stdClass)#17 (2) {
            ["attribute"]=>
            string(8) "filename"
            ["value"]=>
            string(11) "FileCSV.csv"
          }
        }
        ["ifparameters"]=>
        int(1)
        ["parameters"]=>
        array(1) {
          [0]=>
          object(stdClass)#18 (2) {
            ["attribute"]=>
            string(4) "name"
            ["value"]=>
            string(11) "FileCSV.csv"
          }
        }
      }
    }
    [1]=>
    object(stdClass)#37 (4) {
      ["name"]=>
      string(12) "FileTEXT.txt"
      ["charset"]=>
      string(5) "ascii"
      ["body"]=>
      string(9) "File Text"
      ["structure"]=>
      object(stdClass)#19 (13) {
        ["type"]=>
        int(0)
        ["encoding"]=>
        int(3)
        ["ifsubtype"]=>
        int(1)
        ["subtype"]=>
        string(5) "PLAIN"
        ["ifdescription"]=>
        int(0)
        ["ifid"]=>
        int(0)
        ["bytes"]=>
        int(12)
        ["ifdisposition"]=>
        int(1)
        ["disposition"]=>
        string(10) "attachment"
        ["ifdparameters"]=>
        int(1)
        ["dparameters"]=>
        array(1) {
          [0]=>
          object(stdClass)#20 (2) {
            ["attribute"]=>
            string(8) "filename"
            ["value"]=>
            string(12) "FileTEXT.txt"
          }
        }
        ["ifparameters"]=>
        int(1)
        ["parameters"]=>
        array(2) {
          [0]=>
          object(stdClass)#21 (2) {
            ["attribute"]=>
            string(7) "charset"
            ["value"]=>
            string(5) "ascii"
          }
          [1]=>
          object(stdClass)#22 (2) {
            ["attribute"]=>
            string(4) "name"
            ["value"]=>
            string(12) "FileTEXT.txt"
          }
        }
      }
    }
    [2]=>
    object(stdClass)#38 (3) {
      ["name"]=>
      string(11) "FileZIP.zip"
      ["body"]=>
      string(8) "File zip"
      ["structure"]=>
      object(stdClass)#23 (13) {
        ["type"]=>
        int(3)
        ["encoding"]=>
        int(3)
        ["ifsubtype"]=>
        int(1)
        ["subtype"]=>
        string(3) "ZIP"
        ["ifdescription"]=>
        int(0)
        ["ifid"]=>
        int(0)
        ["bytes"]=>
        int(8)
        ["ifdisposition"]=>
        int(1)
        ["disposition"]=>
        string(10) "attachment"
        ["ifdparameters"]=>
        int(1)
        ["dparameters"]=>
        array(1) {
          [0]=>
          object(stdClass)#24 (2) {
            ["attribute"]=>
            string(8) "filename"
            ["value"]=>
            string(11) "FileZIP.zip"
          }
        }
        ["ifparameters"]=>
        int(1)
        ["parameters"]=>
        array(1) {
          [0]=>
          object(stdClass)#25 (2) {
            ["attribute"]=>
            string(4) "name"
            ["value"]=>
            string(11) "FileZIP.zip"
          }
        }
      }
    }
  }
}
```