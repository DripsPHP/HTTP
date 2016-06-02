<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 21.02.2016 - 12:30.
 * Copyright Prowect.
 */
namespace Drips\HTTP;

use Drips\DataStructures\DataCollection;

/**
 * Class Get.
 *
 * $_GET als objektorientierte Implementierung - ermöglicht einen sichereren
 * Zugriff.
 */
class Get extends DataCollection
{
    /**
     * Erzeugt eine neue Get-Instanz.
     */
    public function __construct()
    {
        $this->collection = $_GET;
        $_GET = array();
    }
}
