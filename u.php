<?php
/**
 * Convenience function for creating UTF-8 encoded strings from real Unicode code points.
 * This can be used without composer.
 *
 * Supports '\uxxxx' and '\Uxxxxxx'.
 * @usage <code>echo u('foo\u2714bar');</code>
 * @param string 
 * @return timwhitlock\Unicode\Utf8String
 */
function u( $str ){
    return timwhitlock\Unicode\Utf8String::parse( $str );
}


spl_autoload_register( function( $class ){
    $parts = explode('\\',$class);
    if( 'timwhitlock' === array_shift($parts) ){
        if( file_exists( $path = __DIR__.'/src/'.implode('/',$parts).'.php' ) ){
            require $path;
        }
    }
} );