<?php

namespace tests;

use Drips\HTTP\Get;
use Drips\HTTP\Request;
use PHPUnit_Framework_TestCase;

class RequestTest extends PHPUnit_Framework_TestCase
{
    public function testRequest()
    {
        $_SERVER["REQUEST_METHOD"] = "POST";
        $_SERVER["HTTP_ACCEPT"] = "text/html,application/json;q=0.9";

        $request = Request::getInstance();
        $this->assertTrue($request->isPost());
        $this->assertFalse($request->isGet());
        $this->assertFalse($request->isPatch());
        $this->assertFalse($request->isDelete());
        $this->assertFalse($request->isPut());
        $this->assertTrue($request->isVerb("post"));
        $this->assertFalse(isset($request->auth));
        $request->auth = true;
        $this->assertTrue(isset($request->auth));
        unset($request->auth);
        $this->assertFalse(isset($request->auth));
        $this->assertTrue($request->get instanceof Get);

        $this->assertTrue($request->isValid());
        $this->assertTrue($request->isPost());

        $this->assertFalse(isset($request->nothing));
        unset($request->nothing);
        $this->assertFalse(isset($request->nothing));


        $this->assertTrue(Request::isValidVerb("post"));
        $this->assertFalse(Request::isValidVerb("specialmethod"));

        $this->assertEmpty($request->getAccept());
    }
}
