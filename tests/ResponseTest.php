<?php

namespace tests;

require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit_Framework_TestCase;
use Drips\HTTP\Response;

class ResponseTest extends PHPUnit_Framework_TestCase
{

    public function testResponse()
    {
        $response = Response::getInstance();
        $this->assertFalse($response->isSent());
        $response->send();
        $this->assertTrue($response->isSent());
    }
}
