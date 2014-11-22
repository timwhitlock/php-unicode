<?php

namespace timwhitlock\Unicode\Tests\Utf8String;

use timwhitlock\Unicode\Utf8String;

/**
 * Test Utf8String::parse
 * @group utf8
 */
class ParseTest extends \PHPUnit_Framework_TestCase {
    
    private function u( $text ){
        $u = Utf8String::parse( $text );
        $this->assertInstanceof('timwhitlock\Unicode\Utf8String', $u );
        return $u->__toString();
    }
    
    public function testDoubleByte(){
        $pound = $this->u('\u00A3');
        $this->assertEquals( 2, strlen($pound) );
        $this->assertEquals( "\xC2", $pound{0} );
        $this->assertEquals( "\xA3", $pound{1} );
    }
    
    public function testTripleByte(){
        $tick = $this->u('\u2714');
        $this->assertEquals( 3, strlen($tick) );
        $this->assertEquals( "\xE2", $tick{0} );
        $this->assertEquals( "\x9C", $tick{1} );
        $this->assertEquals( "\x94", $tick{2} );
    }
    
    public function testQuadrupleByte(){
        $smiley = $this->u('\U01F601');
        $this->assertEquals( 4, strlen($smiley) );
        $this->assertEquals( "\xF0", $smiley{0} );
        $this->assertEquals( "\x9F", $smiley{1} );
        $this->assertEquals( "\x98", $smiley{2} );
        $this->assertEquals( "\x81", $smiley{3} );
    }
    
    
}