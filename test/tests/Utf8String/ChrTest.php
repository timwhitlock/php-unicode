<?php

namespace timwhitlock\Unicode\Tests\Utf8String;

use timwhitlock\Unicode\Utf8String;

/**
 * Test Utf8String::chr
 * @group utf8
 */
class ChrTest extends \PHPUnit_Framework_TestCase {
    
    public function testAsciiMatchesPhpChr(){
        for( $i = 0; $i < 0x80; $i++ ){
            $this->assertEquals( chr($i), Utf8String::chr($i) );
        }
    }

    public function testHighAsciiInvalid(){
        for( $i = 0x80; $i <= 0xFF; $i++ ){
            $this->assertNotEquals( chr($i), Utf8String::chr($i) );
        }
    }

    public function testHighAsciiMatchesPhpUtf8Encode(){
        for( $i = 0x80; $i <= 0xFF; $i++ ){
            $this->assertEquals( utf8_encode(chr($i)), Utf8String::chr($i) );
        }
    }
    
    public function testDoubleByte(){
        $pound = Utf8String::chr(0xA3);
        $this->assertEquals( 2, strlen($pound) );
        $this->assertEquals( "\xC2", $pound{0} );
        $this->assertEquals( "\xA3", $pound{1} );
    }
    
    
    public function testTripleByte(){
        $tick = Utf8String::chr(0x2714);
        $this->assertEquals( 3, strlen($tick) );
        $this->assertEquals( "\xE2", $tick{0} );
        $this->assertEquals( "\x9C", $tick{1} );
        $this->assertEquals( "\x94", $tick{2} );
    }
    
    public function testQuadrupleByte(){
        $smiley = Utf8String::chr(0x1F601);
        $this->assertEquals( 4, strlen($smiley) );
        $this->assertEquals( "\xF0", $smiley{0} );
        $this->assertEquals( "\x9F", $smiley{1} );
        $this->assertEquals( "\x98", $smiley{2} );
        $this->assertEquals( "\x81", $smiley{3} );
    }
    
    
}