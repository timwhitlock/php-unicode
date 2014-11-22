<?php

namespace timwhitlock\Unicode;

/**
 * Some static traits for all unicode encoders to share
 */
trait UnicodeTraits {
    
    public static function ord( $str ){
        foreach( static::codes($str) as $code ){
            return $code;
        }
    }
    
}