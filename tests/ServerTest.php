<?php

namespace tests;

require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit_Framework_TestCase;
use Drips\HTTP\Server;

class ServerTest extends PHPUnit_Framework_TestCase
{
    public function testServer(){
        $server = new Server;
        $this->assertTrue($server->has("REQUEST_TIME"));
    }
}
