# Installing
Php-imap-client can be installed 2 ways. The first composer and the second manual
### 1) Composer
Use the following command to install Php-imap-client:    
`composer require sergey144010/php-imap-client dev-master`
### 2) Manual
1) Download the files from github or the releases page    
2) Extract the files into the folder you wish    
3) In the file that will call methods add    
```php
require_once "path/to/php-imap-client/autoload.php";

use sergey144010\ImapClient\ImapClientException;
use sergey144010\ImapClient\ImapClientSimple;
```
You may then use connect etc.

See details about the connection. 
