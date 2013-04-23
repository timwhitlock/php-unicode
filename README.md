# php-unicode

It's a common criticism of PHP that it doesn't have native Unicode support. Printing out a utf8-encoded PHP string might look like this:

<code><?php  
header('Content-Type: text/html; charset=utf8', true );  
echo "\xE2\x9C\x94";  
</code>

But how are you going to know what the utf8 byte sequence should be?
You just want to write "\u2714" like you would in JavaScript. Fair enough.

This library adds the `u()` function to do just that:

<code><?php  
require('php-unicode.php');  
header('Content-Type: text/html; charset=utf8', true );  
echo u('\u2714');  
</code>

The `u()` actually returns an instance of the `UnicodeString` class. Further methods will be added to this in future.
