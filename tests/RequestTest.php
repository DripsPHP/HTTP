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
        $request = new Request;
        $this->assertFalse($request->isPost());
        $this->assertFalse($request->isGet());
        $this->assertFalse($request->isPatch());
        $this->assertFalse($request->isDelete());
        $this->assertFalse($request->isPut());
        $this->assertFalse($request->isVerb("post"));
        $this->assertFalse(isset($request->auth));
        $request->auth = null;
        $this->assertTrue(isset($request->auth));
        unset($request->auth);
        $this->assertFalse(isset($request->auth));
        $this->assertTrue($request->get instanceof Get);
    }
}
