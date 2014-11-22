<?php
/**
 * Print tick mark using the u() syntax
 */

chdir(__DIR__);
require('../u.php');

header('Content-Type: text/html; charset=utf8', true );

echo u('\u2714'),"\n";