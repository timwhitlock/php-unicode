<?php

namespace timwhitlock\Unicode;

/**
 * Base class for all string encoders
 */
abstract class UnicodeString {
    
    use UnicodeTraits;
    
    /**
     * Raw string of encoded bytes
     * @var string
     */    
    private $bytes;

    /**
     * PHP character set string for encoding
     * @var string
     */
    protected $charset;
    

    /**
     * Parse special syntax into properly encoded object
     * @return UnicodeString
     */
    abstract public static function parse( $str );

    /**
     * Encode a Unicode code point to a native encoded string
     * @param int Unicode code point
     * @return string byte sequence
     */
    abstract public static function chr( $code );

    /**
     * Extract Unicode code points from natively encoded string
     * @param string encoded bytes
     * @return array Unicode code points
     */
    abstract public static function codes( $str );

    
    /**
     * Construct from raw bytes already encoded correctly
     */    
    final public function __construct( $bytes = '' ){
        $this->bytes = (string) $bytes;
    }


    /**
     * Get raw bytes in current encoding
     * @return string
     */    
    public function __toString(){
        return $this->bytes;
    }

    
    /**
     * Get HTML encoded for output.
     * Note this doesn't perform full entity escaping as it's not required for unicode rendering
     * @return string
     */
    public function toHTML(){
        return htmlspecialchars( $this->bytes, ENT_COMPAT, $this->charset );
    }

    
}
