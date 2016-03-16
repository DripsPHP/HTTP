<?php

namespace tests;

require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit_Framework_TestCase;
use Drips\HTTP\Response;

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
