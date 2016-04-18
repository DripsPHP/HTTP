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
        $get = new Get;
        $this->assertTrue($get->has($key));
        $this->assertEquals($get->getAll(), $_GET);
        $this->assertEquals($get->get($key), $value);
    }
}
