<?php

namespace tests;

use Drips\HTTP\Server;
use PHPUnit_Framework_TestCase;

class ServerTest extends PHPUnit_Framework_TestCase
{
    public function testServer()
    {
        $server = new Server;
        $this->assertTrue($server->has("REQUEST_TIME"));
    }
}
