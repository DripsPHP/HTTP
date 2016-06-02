<?php

namespace tests;

use PHPUnit_Framework_TestCase;
use Drips\HTTP\Get;

class GetTest extends PHPUnit_Framework_TestCase
{
    public function testGet(){
        $key = "key";
        $value = "value";
        $_GET[$key] = $value;
        $tmp = $_GET;
        $get = new Get;
        $this->assertTrue($get->has($key));
        $this->assertEquals($get->getAll(), $tmp);
        $this->assertEquals($get->get($key), $value);
    }
}
