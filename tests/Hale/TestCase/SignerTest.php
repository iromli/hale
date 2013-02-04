<?php
namespace Hale\TestCase;

use \Hale\Signer\Signer;
use \PHPUnit_Framework_TestCase;

class BaseSignerTest extends PHPUnit_Framework_TestCase
{

    public function testGetSignatureDefault()
    {
        $signer = new Signer('secretkey', 'testing');
        $this->assertEquals(
            'HopKjiR_kQL1OCapGadFAvNd2X4',
            $signer->getSignature('hale')
        );
    }

    public function testGetSignatureConcat()
    {
        $signer = new Signer('secretkey', 'testing', '.', 'concat');
        $this->assertEquals(
            '9uRYhK2FAK_-9U8AWCD4aAoAehw',
            $signer->getSignature('hale')
        );
    }

    public function testGetSignatureHMAC()
    {
        $signer = new Signer('secretkey', 'testing', '.', 'hmac');
        $this->assertEquals(
            '1McL-UOJfEaeDOoyu613afTnCtU',
            $signer->getSignature('hale')
        );
    }

    public function testGetSignatureRandom()
    {
        $signer = new Signer('secretkey', 'testing', '.', 'random');
        $this->setExpectedException('InvalidArgumentException');
        $this->assertEquals(
            'r4nd0m516n4tur3',
            $signer->getSignature('hale')
        );
    }

    public function testSign()
    {
        $signer = new Signer('secretkey', 'testing');
        $signedStr = 'hale.HopKjiR_kQL1OCapGadFAvNd2X4';
        $this->assertEquals($signedStr, $signer->sign('hale'));
    }

    public function testUnsignNoSeparator()
    {
        $signer = new Signer('secretkey', 'testing');
        $signedStr = 'hale#HopKjiR_kQL1OCapGadFAvNd2X4';

        $this->setExpectedException('Hale\Exception\BadSignatureException');
        $this->assertEquals('hale', $signer->unsign($signedStr));
    }

    public function testUnsignDoesNotMatch()
    {
        $signer = new Signer('secretkey', 'testing');
        $signedStr = 'hale.HopKjiR_kQL1OCapGadFAvNd2X';

        $this->setExpectedException('Hale\Exception\BadSignatureException');
        $this->assertEquals('hale', $signer->unsign($signedStr));
    }

    public function testUnsign()
    {
        $signer = new Signer('secretkey', 'testing');
        $signedStr = 'hale.HopKjiR_kQL1OCapGadFAvNd2X4';
        $this->assertEquals('hale', $signer->unsign($signedStr));
    }

}
