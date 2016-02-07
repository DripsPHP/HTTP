<?php

namespace tests;

session_start();
require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit_Framework_TestCase;
use Drips\HTTP\Session;
use StdClass;

class SessionTest extends PHPUnit_Framework_TestCase
{
    public function testSession()
    {
        $session = new Session();
        $session->set("one", 1);
        $session->set("two", 2);
        $this->assertTrue($session->has("one"));
        $this->assertFalse($session->has("three"));
        $this->assertNull($session->get("not_found"));
        $this->assertEquals($session->get("one"), 1);
    }

    public function testWithValues()
    {
        $_SESSION["DRIPS_INFO"]["test"]["expire"] = true;
        $_SESSION["DRIPS"]["test"] = "Test";
        $_SESSION["DRIPS_INFO"]["test2"]["expire"] = -1;
        $_SESSION["DRIPS"]["test2"] = "Test2";
        $session = new Session();
        $this->assertEquals($session->get("test"), "Test");
        $this->assertEquals($session->get("test2"), "Test2");
    }

    public function testSerialize()
    {
        $session = new Session();
        $obj = new StdClass;
        $session->set("obj", $obj);
        $this->assertEquals($session->get("obj"), $obj);
    }

    public function testDelete()
    {
        $collection = new Session;
        $this->assertFalse($collection->delete("key"));
        $this->assertFalse($collection->has("key"));
        $collection->set("key", 123);
        $this->assertTrue($collection->has("key"));
        $this->assertTrue($collection->delete("key"));
        $this->assertFalse($collection->has("key"));
    }

    public function testArrayAccess()
    {
        $collection = new Session;
        $collection[] = "nulltes";
        $this->assertEquals(count($collection), 1);
        $this->assertFalse(isset($collection["töst"]));
        $collection["töst"] = "EINZ";
        $this->assertTrue(isset($collection["töst"]));
        $this->assertEquals($collection["töst"], "EINZ");
        unset($collection["töst"]);
        $this->assertFalse(isset($collection["töst"]));
    }

    public function testStorage()
    {
        $session = new Session();
        $result = $session->getAll();
        $this->assertTrue(empty($result));
        $session->set("abc", 123);
        $result = $session->getAll();
        $this->assertFalse(empty($result));
    }

    public function testWithExpire()
    {
        $session = new Session("MY_SESSION");
        $session->set("key", 123, true);
        $this->assertEquals($session->get("key"), 123);
    }
}
