<?php
namespace Hale;

use Hale\Util;

class UtilTest extends \PHPUnit_Framework_TestCase
{

    public function testBase64Encode()
    {
        $haystack = Util::base64Encode('a secret string');
        $this->assertNotContains('+', $haystack);
        $this->assertNotContains('/', $haystack);
        $this->assertNotContains('=', $haystack);
    }

    public function testBase64Decode()
    {
        $haystack = Util::base64Decode('-YSBzZWNyZXQgc3RyaW5n_');
        $this->assertNotContains('-', $haystack);
        $this->assertNotContains('_', $haystack);
    }

}
