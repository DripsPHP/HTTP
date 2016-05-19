<?php

namespace tests;

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
        $this->assertFalse($request->isPost());

        $_SERVER["REQUEST_METHOD"] = "POST";
        $_SERVER["HTTP_ACCEPT"] = "text/html,application/json;q=0.9";

        $request = new Request;
        $this->assertTrue($request->isValid());
        $this->assertTrue($request->isPost());

        $this->assertFalse(isset($request->nothing));
        unset($request->nothing);
        $this->assertFalse(isset($request->nothing));

        $this->assertTrue(isset($request->server));
        unset($request->server);
        $this->assertFalse(isset($request->server));
        $this->assertEquals(null, $request->server);

        $this->assertTrue(Request::isValidVerb("post"));
        $this->assertFalse(Request::isValidVerb("specialmethod"));

        $this->assertEquals(null, $request->nothing);
        $this->assertEmpty($request->getAccept());
    }
}
