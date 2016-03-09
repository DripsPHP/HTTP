<?php

namespace tests;

require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit_Framework_TestCase;
use Drips\HTTP\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testResponse()
    {
        $response = new Response;
        $this->assertFalse(Response::isSent());
        $response->send();
        $this->assertTrue(Response::isSent());
    }
}
