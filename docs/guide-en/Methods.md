# Explanations to some methods

## getFolders()
```php
getFolders($separator = null, $type = 0)
```
Returns all available folders

@param string $separator default is '.'

@param integer $type has three meanings 0,1,2.
If 0 return nested array, if 1 return an array of strings, if 2 return raw imap_list()

@return array with folder names