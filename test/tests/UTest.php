<?php
/**
 * Test UTF-8 "u" function
 * @group php-unicode
 */
class UTest extends PHPUnit_Framework_TestCase {
    
    public function testDoubleByte(){
        $pound = (string) u('\u00A3');
        $this->assertEquals( 2, strlen($pound) );
        $this->assertEquals( "\xC2", $pound{0} );
        $this->assertEquals( "\xA3", $pound{1} );
    }
    
    public function testTripleByte(){
        $tick = (string) u('\u2714');
        $this->assertEquals( 3, strlen($tick) );
        $this->assertEquals( "\xE2", $tick{0} );
        $this->assertEquals( "\x9C", $tick{1} );
        $this->assertEquals( "\x94", $tick{2} );
    }
    
    public function testQuadrupleByte(){
        $smiley = (string) u('\U01F601');
        $this->assertEquals( 4, strlen($smiley) );
        $this->assertEquals( "\xF0", $smiley{0} );
        $this->assertEquals( "\x9F", $smiley{1} );
        $this->assertEquals( "\x98", $smiley{2} );
        $this->assertEquals( "\x81", $smiley{3} );
    }
    
    
}