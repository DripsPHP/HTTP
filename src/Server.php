<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 21.02.2016 - 12:30.
 * Copyright Prowect.
 */
namespace Drips\HTTP;

/**
 * Class Server.
 *
 * $_SERVER als objektorientierte Implementierung - ermöglicht einen sichereren
 * Zugriff.
 */
class Server extends Get
{
    public function __construct()
    {
        $this->collection = $_SERVER;
        $_SERVER = array();
    }
}
