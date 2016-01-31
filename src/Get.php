<?php

namespace Drips\HTTP;

use Drips\DataStructures\DataCollection;

class Get extends DataCollection
{
    public function __construct($array = array()){
        $this->collection = $_GET;
    }
}
