<?php

namespace tests;

use Drips\HTTP\Response;
use PHPUnit_Framework_TestCase;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    public function testResponse()
    {
        $response = new Response;
        $this->assertFalse(Response::isSent());
        $response->setHeader("Content-Type", "text/html");
        $response->unsetHeader("Cache-Control");
        $response->unsetHeader("Cache-Control");
        $this->assertTrue($response->send());
        $this->assertTrue(Response::isSent());

        $response = new Response;
        $this->assertFalse($response->send());
    }
}
