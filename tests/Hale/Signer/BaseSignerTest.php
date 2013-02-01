<?php
namespace Hale;

use \Hale\Signer\BaseSigner;

class SignerTest extends \PHPUnit_Framework_TestCase
{

    public function testGetSignatureDefault()
    {
        $signer = new BaseSigner('secretkey', 'testing');
        $this->assertEquals(
            'HopKjiR_kQL1OCapGadFAvNd2X4',
            $signer->getSignature('hale')
        );
    }

    public function testGetSignatureConcat()
    {
        $signer = new BaseSigner('secretkey', 'testing', '.', 'concat');
        $this->assertEquals(
            '9uRYhK2FAK_-9U8AWCD4aAoAehw',
            $signer->getSignature('hale')
        );
    }

    public function testGetSignatureHMAC()
    {
        $signer = new BaseSigner('secretkey', 'testing', '.', 'hmac');
        $this->assertEquals(
            '1McL-UOJfEaeDOoyu613afTnCtU',
            $signer->getSignature('hale')
        );
    }

    public function testGetSignatureRandom()
    {
        $signer = new BaseSigner('secretkey', 'testing', '.', 'random');
        $this->setExpectedException('InvalidArgumentException');
        $this->assertEquals(
            'r4nd0m516n4tur3',
            $signer->getSignature('hale')
        );
    }

    public function testSign()
    {
        $signer = new BaseSigner('secretkey', 'testing');
        $signedStr = 'hale.HopKjiR_kQL1OCapGadFAvNd2X4';
        $this->assertEquals($signedStr, $signer->sign('hale'));
    }

}
