<?php

namespace tests;

require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit_Framework_TestCase;
use Drips\HTTP\Request;
use Drips\HTTP\Get;

class RequestTest extends PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $request = Request::getInstance();
        $this->assertFalse($request->isPost());
        $this->assertFalse($request->isGet());
        $this->assertFalse($request->isPatch());
        $this->assertFalse($request->isDelete());
        $this->assertFalse($request->isPut());
        $this->assertFalse($request->isVerb("post"));
        $this->assertFalse($request->hasObject("auth"));
        $request->register("auth", null);
        $this->assertTrue($request->hasObject("auth"));
        $this->assertTrue($request->unregister("auth"));
        $this->assertFalse($request->hasObject("auth"));
        $this->assertTrue($request["get"] instanceof Get);
    }
}
