<?php

namespace tests;

use Drips\HTTP\Cookie;
use PHPUnit_Framework_TestCase;

class CookieTest extends PHPUnit_Framework_TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testCookie()
    {
        $cookies = new Cookie;
        $this->assertFalse($cookies->delete("test"));
        $cookies->set("test", 123);
        $this->assertTrue($cookies->has("test"));
        $cookies->delete("test");
        $this->assertFalse($cookies->has("test"));
    }
}
