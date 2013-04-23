# php-unicode

It's a common criticism of PHP, that it doesn't have native Unicode support.
Even 15 year old JavaScript manages that. Except not really, because it only goes up to [0xFFFF](https://developer.mozilla.org/en-US/docs/JavaScript/Reference/Global_Objects/String/charCodeAt)
whereas Unicode goes up to 0x10FFFF

<pre><?php
header('Content-Type: text/html; charset=utf8', true );
echo "\xE2\x9C\x94";
</pre>

Bingo. Unicode.

Ok, so how are you going to know what the utf8 byte sequence to use? You just want to write "\u2714" like you would in JavaScript. Fair enough.

This library adds the <code>u</code> function to do just that:

<pre><?php
require('php-unicode.php');
header('Content-Type: text/html; charset=utf8', true );
echo u('\u2714');
</pre>

