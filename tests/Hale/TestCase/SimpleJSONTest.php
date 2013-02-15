<?php
namespace Hale\TestCase;

use \PHPUnit_Framework_TestCase;

class SimpleJSONTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        $this->signer = new \Hale\SimpleJSON();
    }

    public function tearDown()
    {
        $this->signer = null;
    }

    public function testLoads()
    {
        $this->assertEquals(
            array('a' => 'foo', 'b' => 'bar'),
            $this->signer->loads('{"a": "foo", "b": "bar"}')
        );
    }

    public function testDumps()
    {
        $this->assertEquals(
            $this->signer->dumps(array('a' => 'foo', 'b' => 'bar')),
            '{"a":"foo","b":"bar"}'
        );
    }

}
