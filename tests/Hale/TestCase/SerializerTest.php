<?php
namespace Hale\TestCase;

use \PHPUnit_Framework_TestCase;

class DummySerializer
{

    public function dumps() {}

    public function loads() {}

}

class DummySigner
{

    public function sign() {}

    public function unsign() {}

}

class SerializerTest extends PHPUnit_Framework_TestCase
{

    public function testGetDefaultSerializer()
    {
        $s = new \Hale\Serializer\Serializer('secretkey', 'testing');
        $this->assertInstanceOf('Hale\SimpleJSON', $s->getSerializer());
    }

    public function testGetCustomSerializer()
    {
        $dummy = $this->getMock(
            'Hale\TestCase\DummySerializer', array(), array(), 'DummySerializer'
        );
        $s = new \Hale\Serializer\Serializer('secretkey', 'testing', '.', 'default', $dummy);
        $this->assertInstanceOf('DummySerializer', $s->getSerializer());
    }

    public function testDumpPayload()
    {
        // Since there's demeter chain in Serializer class,
        // we mock the `Serializer::serializer->dumps`
        // because we only need to check whether the method is exist
        $dummy = $this->getMock('Hale\TestCase\DummySerializer');
        $dummy->expects($this->any())
              ->method('dumps')
              ->will($this->returnValue(true));

        $s = new \Hale\Serializer\Serializer('secretkey', 'testing', '.', 'default', $dummy);
        $this->assertTrue($s->dumpPayload(true));
    }

    public function testLoadPayload()
    {
        // Since there's demeter chain in Serializer class,
        // we mock the `Serializer::serializer->loads`
        // because we only need to check whether the method is exist
        $dummy = $this->getMock('Hale\TestCase\DummySerializer');
        $dummy->expects($this->any())
              ->method('loads')
              ->will($this->returnValue(true));

        $s = new \Hale\Serializer\Serializer('secretkey', 'testing', $dummy);
        $this->assertTrue($s->loadPayload('true'));
    }

    public function testGetDefaultSigner()
    {
        $s = new \Hale\Serializer\Serializer('secretkey', 'testing');
        $this->assertInstanceOf('Hale\Signer\Signer', $s->getSigner());
    }

    public function testGetCustomSigner()
    {
        $dummy = $this->getMock(
            'Hale\TestCase\DummySigner', array(), array(), 'DummySigner'
        );
        $s = new \Hale\Serializer\Serializer(
            'secretkey', 'testing', '.', 'default', null, $dummy
        );
        $this->assertInstanceOf('DummySigner', $s->getSigner());
    }

}
