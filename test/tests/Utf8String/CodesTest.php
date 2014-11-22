<?php

namespace timwhitlock\Unicode\Tests\Utf8String;

use timwhitlock\Unicode\Utf8String;

/**
 * Test Utf8String::codes
 * @group utf8
 */
class CodesTest extends \PHPUnit_Framework_TestCase {
    
    public function testAsciiMatchesPhpOrd(){
        for( $i = 0; $i < 0x80; $i++ ){
            $codes = Utf8String::codes( chr($i) );
            $this->assertEquals( array($i), $codes );
        }
    }

    public function testHighAsciiMatchesPhpUtf8Decode(){
        for( $i = 0x80; $i <= 0xFF; $i++ ){
            $singlebyte = chr($i);
            $multibyte = utf8_encode($singlebyte);
            $codes = Utf8String::codes( $multibyte );
            $this->assertEquals( array($i), $codes );
        }
    }


    public function testDoubleByte(){
        $this->assertEquals( array( 0xA3, 0x20AC ), Utf8String::codes('£€') );
    }


    public function testTripleBytes(){
        $this->assertEquals( array( 0x2714, 0x2715 ), Utf8String::codes('✔✕') );
    }
    
    public function testQuadrupleByte(){
        $this->assertEquals( array( 0x1F601 ), Utf8String::codes("\xF0\x9F\x98\x81") );
    }


}