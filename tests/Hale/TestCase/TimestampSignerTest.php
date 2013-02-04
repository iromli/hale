<?php
namespace Hale\TestCase;

use \Hale\Signer\TimestampSigner;
use \PHPUnit_Framework_TestCase;

class TimestampSignerTest extends PHPUnit_Framework_TestCase
{

    public function testGetTimestamp()
    {
        $signer = new TimestampSigner('secretkey', 'testing');
        $this->assertInternalType('int', $signer->getTimestamp());
    }

    public function testTimestampToDatetime()
    {
        $signer = new TimestampSigner('secretkey', 'testing');
        $datetime = $signer->timestampToDatetime($signer->getTimestamp());
        $this->assertInstanceOf('DateTime', $datetime);
        $this->assertEquals('UTC', $datetime->getTimezone()->getName());
    }

    public function testSign()
    {
        $stub = $this->getMockBuilder('\Hale\Signer\TimestampSigner')
                     ->setConstructorArgs(array('secretkey', 'testing'))
                     ->getMock();

        $stub->expects($this->any())
             ->method('getTimestamp')
             ->will($this->returnValue('12345'));

        $stub->expects($this->any())
             ->method('sign')
             ->will($this->returnValue(
                 'hale.A-0-6w.YUL7HLva97xrJBLbQlNNBuq04rY'
             ));

        $signedStr = 'hale.A-0-6w.YUL7HLva97xrJBLbQlNNBuq04rY';
        $this->assertEquals($signedStr, $stub->sign('hale'));
    }

}
