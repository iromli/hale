<?php
namespace Hale\TestCase;

use \PHPUnit_Framework_TestCase;
use \Hale\Hash\SHA1;

class SHA1Test extends PHPUnit_Framework_TestCase
{

    public function testDigest()
    {
        $str = 'foo';
        $sha1 = new SHA1();
        $this->assertEquals($sha1->digest($str), sha1($str, true));
    }

}
