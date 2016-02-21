<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 21.02.2016 - 12:30.
 * Copyright Prowect.
 */
namespace Drips\HTTP;

/**
 * Class Post.
 *
 * $_POST als objektorientierte Implementierung - ermöglicht einen sichereren
 * Zugriff.
 */
class Post extends Get
{
    /**
     * Erzeugt eine neue Post-Instanz.
     */
    public function __construct()
    {
        $this->collection = $_POST;
    }
}
