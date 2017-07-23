<?php
require_once "ImapClient/MessageIdentifierInterface.php";
require_once "ImapClient/GetMessageInterface.php";

require_once "ImapClient/ImapClientException.php";
require_once "ImapClient/Part.php";
require_once "ImapClient/AdapterForOutgoingMessage.php";
require_once "ImapClient/Helper.php";
require_once "ImapClient/ImapClient.php";
require_once "ImapClient/ImapClientSimple.php";
require_once "ImapClient/ImapHelper.php";
require_once "ImapClient/MessageIdentifier.php";
require_once "ImapClient/OutgoingMessage.php";

require_once "ImapClient/Connect/Interfaces/ParametersInterface.php";
require_once "ImapClient/Connect/Interfaces/MailboxInterface.php";
require_once "ImapClient/Connect/Interfaces/FlagsInterface.php";
require_once "ImapClient/Connect/Interfaces/ImapConnectInterface.php";

require_once "ImapClient/Connect/Parameters.php";
require_once "ImapClient/Connect/Mailbox.php";
require_once "ImapClient/Connect/Flags.php";
require_once "ImapClient/Connect/ImapConnect.php";

require_once "ImapClient/IncomingMessage/Interfaces/IncomingMessageInterface.php";
require_once "ImapClient/IncomingMessage/Interfaces/TypeInterface.php";

require_once "ImapClient/IncomingMessage/Subtype.php";
require_once "ImapClient/IncomingMessage/TypeAttachments.php";
require_once "ImapClient/IncomingMessage/TypeBody.php";
require_once "ImapClient/IncomingMessage/AllowTypes.php";
require_once "ImapClient/IncomingMessage/CalculateParts.php";
require_once "ImapClient/IncomingMessage/Body.php";
require_once "ImapClient/IncomingMessage/Message.php";
require_once "ImapClient/IncomingMessage/Attachments.php";
require_once "ImapClient/IncomingMessage/IncomingMessage.php";

require_once "tests/MessageInterface.php";

require_once "tests/MessagesPool.php";
require_once "tests/Message.php";
require_once "tests/SimpleMessage.php";
require_once "tests/LoadMessage.php";
require_once "tests/Steps.php";