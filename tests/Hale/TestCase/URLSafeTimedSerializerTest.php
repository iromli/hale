<?php
namespace Hale\TestCase;

use \PHPUnit_Framework_TestCase;

class URLSafeTimedSerializerTest extends PHPUnit_Framework_TestCase
{
    public function testGetDefaultSerializer()
    {
        $s = new \Hale\Serializer\TimedSerializer('secretkey', 'testing');
        $this->assertInstanceOf('Hale\SimpleJSON', $s->getSerializer());
    }

    public function testGetCustomSerializer()
    {
        $dummy = $this->getMock(
            'Hale\TestCase\DummySerializer', array(), array(), 'DummySerializer'
        );
        $s = new \Hale\Serializer\TimedSerializer('secretkey', 'testing', '.', 'default', $dummy);
        $this->assertInstanceOf('DummySerializer', $s->getSerializer());
    }


}
