<?php

namespace tests;

require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit_Framework_TestCase;
use Drips\HTTP\Cookie;

class CookieTest extends PHPUnit_Framework_TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testCookie()
    {
        $cookies = new Cookie;
        $cookies->set("test", 123);
        $this->assertTrue($cookies->has("test"));
        $cookies->delete("test");
        $this->assertFalse($cookies->has("test"));
    }
}
