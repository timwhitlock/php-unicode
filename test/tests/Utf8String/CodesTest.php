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

}