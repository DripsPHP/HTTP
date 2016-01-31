<?php

namespace Drips\HTTP;

class Server extends Get
{
    public function __construct($array = array()){
        $this->collection = $_SERVER;
    }
}
