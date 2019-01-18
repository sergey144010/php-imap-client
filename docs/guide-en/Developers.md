
ImapClient -> Builder -> Skeleton <- imap

Builder строит из Skeleton message.
Builder возвращает Message

Над Message нужно подумать что в нём должно быть
Может быть 
Message->getHeaders()->getStructure()
или
Message->getStructure()