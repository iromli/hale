<?php
namespace Hale;

use \Hale\Signer;

class SignerTest extends \PHPUnit_Framework_TestCase
{

    public function testGetSignatureDefault()
    {
        $signer = new Signer('secretkey', '.', 'testing');
        $this->assertEquals(
            'lpo0X_mDjkpAMT4kRlZIhm3wvrc',
            $signer->getSignature('hale')
        );
    }

    public function testGetSignatureConcat()
    {
        $signer = new Signer('secretkey', '.', 'testing', 'concat');
        $this->assertEquals(
            'gDOhR05CiaUi-Sc7RWQdUBCeuDI',
            $signer->getSignature('hale')
        );
    }

    public function testGetSignatureHMAC()
    {
        $signer = new Signer('secretkey', '.', 'testing', 'hmac');
        $this->assertEquals(
            'aV7mf48DbrsLs9FU1z78LmwmNzw',
            $signer->getSignature('hale')
        );
    }

    public function testGetSignatureRandom()
    {
        $signer = new Signer('secretkey', '.', 'testing', 'random');
        $this->setExpectedException('InvalidArgumentException');
        $this->assertEquals(
            'r4nd0m516n4tur3',
            $signer->getSignature('hale')
        );
    }

    public function testSign()
    {
        $signer = new Signer('secretkey');
        $signedStr = 'hale.NpskTt46QpgdwRBc5-rQ_zvgNuI';
        $this->assertEquals($signedStr, $signer->sign('hale'));
    }

}
