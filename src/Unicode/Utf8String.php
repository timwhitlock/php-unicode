<?php

namespace timwhitlock\Unicode;
 

/**
 * Object holding a utf8-encoded PHP string.
 */
class Utf8String extends UnicodeString {

    /**
     * PHP character set string for UTF8
     * @var string
     */
    protected $charset = 'UTF-8';
    

    /**
     * Expand Unicode embedded string, supports \uxxxx and \Uxxxxxx
     * @param string
     * @return Utf8String
     */
    public static function parse( $str ){
        static $callback = array( __CLASS__, 'parse_replace' );
        return new Utf8String( preg_replace_callback('!(?:\\\u[a-fA-F0-9]{4}|\\\U[a-fA-F0-9]{6})!', $callback, $str ) );
    } 

    

    /**
     * @internal
     */
    private static function parse_replace( array $r ){
        return self::chr( intval( substr( $r[0], 2 ), 16 ) );
    }


    
    /**
     * Encode a Unicode code point to a utf8 encoded string
     * @param int Unicode code point up to 0x10FFFF
     * @return string utf8 byte sequence
     */
    public static function chr( $u ){
        // 7-bit ASCII
        if( 127 === ( $u | 127 ) ){
            return chr( $u );
        }
        // Double byte sequence ( < 0x800 )
        // 00000yyy yyzzzzzz ==> 110yyyyy 10zzzzzz
        if( 0 === ( $u & 0xFFFFF800 ) ){
            $c = chr( $u & 63 | 128 );            // "10zzzzzz"
            $c = chr( ($u>>=6) & 31 | 192 ) . $c; // "110yyyyy"
        }
        // Triple byte sequence ( < 0x10000 )
        // xxxxyyyy yyzzzzzz ==> 1110xxxx 10yyyyyy 10zzzzzz
        else if( 0 === ( $u & 0xFFFF0000 ) ){
            $c = chr( $u & 63 | 128 );            // "10zzzzzz"
            $c = chr( ($u>>=6) & 63 | 128 ) . $c; // "10yyyyyy"
            $c = chr( ($u>>=6) & 15 | 224 ) . $c; // "1110xxxx"
        }
        // Four byte sequence ( < 0x10FFFF )
        // 000wwwxx xxxxyyyy yyzzzzzz ==> 11110www 10xxxxxx 10yyyyyy 10zzzzzz
        else if( 0 === ( $u & 0xE0000000 ) ){
            $c = chr( $u & 63 | 128 );            // "10zzzzzz"
            $c = chr( ($u>>=6) & 63 | 128 ) . $c; // "10yyyyyy"
            $c = chr( ($u>>=6) & 63 | 128 ) . $c; // "10xxxxxx"
            $c = chr( ($u>>=6) &  7 | 240 ) . $c; // "11110www"
        }
        else {
            trigger_error("Unicode code point too large, $u", E_USER_NOTICE );
            $c = '?';
        }
        return $c;
    }



    /**
     * Extract Unicode code points from utf-8 encoded string
     * @param string utf-8 encoded bytes
     * @return array Unicode code points
     */
    public static function codes( $str ){
        $a = array();
        $str = (string) $str;
        $len = strlen($str);
        for( $i = 0; $i < $len; $i++ ){
            $c = $str{ $i };
            $n = ord( $c );
            // 7-bit ASCII
            if( 0 === ( $n & 128 ) ){
                isset( $t ) and $a [] = $t;
                $a[] = $n;
                unset( $t );
            }
            // Subsequent 10xxxxxx character
            else if( isset($t) && ( $n & 192 ) === 128 ){
                $t <<= 6;
                $t |= ( $n & 63 ); 
            }
            // Leading char in 2 byte sequence "110xxxxx"
            else if( ( $n & 224 ) === 192 ){
                isset( $t ) and $a [] = $t;
                $t = ( $n & 31 );
            }
            // Leading char in 3 byte sequence "1110xxxx"
            else if( ( $n & 240 ) === 224 ){
                isset( $t ) and $a [] = $t;
                $t = ( $n & 15 ); 
            }
            // Leading char in 4 byte sequence "11110xxx"
            else if( ( $n & 248 ) === 240 ){
                isset( $t ) and $a [] = $t;
                $t = ( $n & 7 );
            }
            else {
                trigger_error("Invalid utf8 string, unexpected character at offset $i ($c)", E_USER_WARNING );
                isset( $t ) and $a [] = $t;
                $a[] = $n;
                unset( $t );
            }
        }
        // left over
        isset( $t ) and $a [] = $t;
        return $a;        
    }


    
}

