<?php

namespace timwhitlock\Unicode\Tests\Utf8String;

use timwhitlock\Unicode\Utf8String;

/**
 * Test UnicodeTraits::ord
 * @group utf8
 */
class OrdTest extends \PHPUnit_Framework_TestCase {
    
    public function testUtf8StringHasOrdTrait(){
        $this->assertSame( 0x20, Utf8String::ord(' ') );
    }

}