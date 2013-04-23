<?php
/**
 * PHP Unicode utilities
 * https://github.com/timwhitlock/php-unicode
 * @author Tim Whitlock
 * @license MIT
 */

 

/**
 * Expand Unicode embedded string, supports '\uxxxx' and '\Uxxxxxx'.
 * @usage <code>echo u('foo\u2714bar');</code>
 * @param string 
 * @return UnicodeString
 */
function u( $str ){
    return UnicodeString::parse( $str );
}




/**
 * Object holding a utf8-encoded PHP string.
 */
class UnicodeString {
    
    /**
     * Raw string of bytes encoded as utf8
     * @var string
     */    
    private $bytes;
    
    /**
     * Construct UnicodeString from raw bytes already encoded correctly
     */    
    public function __construct( $bytes = '' ){
        $this->bytes = (string) $bytes;
    }

    /**
     * Get raw bytes encoded as utf8
     * @return string
     */    
    public function __toString(){
        return $this->bytes;
    }
    
    /**
     * Get HTML encoded for utf8 output.
     * Note this doesn't perform full entity escaping as it's not required for utf8 rendering
     * @return string
     */
    public function html(){
        return htmlspecialchars( $this->bytes, ENT_COMPAT, 'UTF-8' );
    }
    
    /**
     * Expand Unicode embedded string, supports \uxxxx and \Uxxxxxx
     * @param string
     * @return UnicodeString
     */
    public static function parse( $str ){
        static $callback = array( __CLASS__, 'parse_replace' );
        return new UnicodeString( preg_replace_callback('!(?:\\\u[a-fA-F0-9]{4}|\\\U[a-fA-F0-9]{6})!', $callback, $str ) );
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
     * @return string utf8 character sequence
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
    
}

