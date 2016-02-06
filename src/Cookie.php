<?php

namespace Drips\HTTP;

use Drips\DataStructures\DataCollection;

class Cookie extends DataCollection
{
    public function __construct($array = array())
    {
        $this->collection = $_COOKIE;
    }

    public function set($key, $value, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = false)
    {
        if($expire != 0){
            $expire = time() + $expire;
        }
        if(setcookie($key, $value, $expire, $path, $domain, $secure, $httponly)){
            $this->collection[$key] = $value;
            return true;
        }
        return false;
    }

    public function delete($key)
    {
        if($this->has($key)){
            if($this->set($key, null, -1)){
                unset($this->collection[$key]);
                return true;
            }
        }
        return false;
    }
}
