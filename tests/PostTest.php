<?php

namespace tests;

session_start();
require_once __DIR__.'/../vendor/autoload.php';

use PHPUnit_Framework_TestCase;
use Drips\HTTP\Post;

class PostTest extends PHPUnit_Framework_TestCase
{
    public function testPost(){
        $key = "key";
        $value = "value";
        $_POST[$key] = $value;
        $post = new Post;
        $this->assertTrue($post->has($key));
        $this->assertEquals($post->getAll(), $_POST);
        $this->assertEquals($post->get($key), $value);
    }
}
