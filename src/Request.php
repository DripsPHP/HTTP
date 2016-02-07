<?php

namespace Drips\HTTP;

use ArrayAccess;

class Request implements ArrayAccess
{
    private static $instance = null;
    protected $container = array();

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function register($name, $obj)
    {
        $this->container[$name] = $obj;
    }

    public function hasObject($name)
    {
        return array_key_exists($name, $this->container);
    }

    public function unregister($name)
    {
        if($this->hasObject($name)){
            unset($this->container[$name]);
            return true;
        }
        return false;
    }

    public function isGet()
    {
        return $this->isVerb("get");
    }

    public function isPost()
    {
        return $this->isVerb("post");
    }

    public function isPatch()
    {
        return $this->isVerb("patch");
    }

    public function isPut()
    {
        return $this->isVerb("put");
    }

    public function isDelete()
    {
        return $this->isVerb("delete");
    }

    public function isVerb($verb)
    {
        return strtoupper($this->container["server"]->get("REQUEST_METHOD")) == strtoupper($verb);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
           $this->container[] = $value;
        } else {
           $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
       return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
       unset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
       return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    private function __construct()
    {
        $this->register("cookie", new Cookie);
        $this->register("get", new Get);
        $this->register("server", new Server);
        $this->register("session", new Session);
        if($this->isPost()){
            $this->register("post", new Post);
        }
    }

    private function __clone(){}
}
