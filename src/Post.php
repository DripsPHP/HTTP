<?php

namespace Drips\HTTP;

class Post extends Get
{
    public function __construct($array = array()){
        $this->collection = $_POST;
    }
}
