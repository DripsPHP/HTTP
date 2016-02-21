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
 * Class Cookie.
 *
 * Ermöglicht erweiterte Funktionalität mit Cookies. Funktioniert grundsätzlich
 * genau wie der Zugriff über $_COOKIE, ist jedoch sicherer und funktionsreicher.
 */
class Cookie extends DataCollection
{
    /**
     * Gibt eine neue Cookie-Instanz zurück.
     */
    public function __construct()
    {
        $this->collection = $_COOKIE;
    }

    /**
     * Setzt ein neues Cookie. Funktioniert grundsätzlich genauso wie die, von
     * PHP zur Verfügung gestellte setcookie-Funktion.
     * Der Unterschied besteht darin, dass das Cookie automatisch lokal auch
     * gesetzt wird und nicht time()+$expire angegeben werden muss sondern nur
     * die Dauer, da die time() automatisch hinzu addiert wird.
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $expire
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httponly
     *
     * @return bool
     */
    public function set($key, $value, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = false)
    {
        if ($expire != 0) {
            $expire = time() + $expire;
        }
        if (setcookie($key, $value, $expire, $path, $domain, $secure, $httponly)) {
            $this->collection[$key] = $value;

            return true;
        }

        return false;
    }

    /**
     * Löscht ein bereits bestehendes Cookie. Liefert zurück, ob der Löschvorgang
     * erfolgreich war oder nicht.
     *
     * @param string $key Name hinterdem das Cookie hinterlegt wurde
     *
     * @return bool
     */
    public function delete($key)
    {
        if ($this->has($key)) {
            if ($this->set($key, null, -1)) {
                unset($this->collection[$key]);

                return true;
            }
        }

        return false;
    }
}
