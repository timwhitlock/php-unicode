# NO LONGER MAINTAINED

PHP 7 now has native Unicode support.

---

# php-unicode

Utilities for working with Unicode characters in PHP.

The following prints a multi-byte tick mark from the code point [U+2714](http://apps.timwhitlock.info/unicode/inspect/hex/2714).

```php
   require('u.php');  
   header('Content-Type: text/html; charset=utf8', true );  
   echo u('\u2714');  
```

For further documentation, see the tests.
