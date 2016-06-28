<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 21.02.2016 - 12:30.
 * Copyright Prowect.
 */
namespace Drips\HTTP;

/**
 * Class Request.
 *
 * Diese Klasse dient als Container für Session, Get, Post, Server, Cookie, usw.
 * Außerdem enthält sie Informationen zum eingegangenen HTTP-Request.
 */
class Request
{
    /**
     * Beinhaltet alle gültigen Request-Methoden.
     */
    public static $verbs = array('get', 'post', 'put', 'delete', 'patch');

    private static $instance;

    public static function getInstance()
    {
        if(static::$instance === null){
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Erzeugt eine neue Request-Instanz.
     */
    private function __construct()
    {
        $this->cookie = new Cookie;
        $this->get = new Get;
        $this->server = new Server;
        $this->session = new Session;
        if ($this->isPost()) {
            $this->post = new Post;
        }
    }

    private function __clone(){}

    /**
     * Gibt zurück, ob es sich bei dem aktuellen HTTP-Request um einen GET-Request
     * handelt.
     *
     * @return bool
     */
    public function isGet()
    {
        return $this->isVerb('get');
    }

    /**
     * Gibt zurück, ob es sich bei dem aktuellen HTTP-Request um einen POST-Request
     * handelt.
     *
     * @return bool
     */
    public function isPost()
    {
        return $this->isVerb('post');
    }

    /**
     * Gibt zurück, ob es sich bei dem aktuellen HTTP-Request um einen PATCH-Request
     * handelt.
     *
     * @return bool
     */
    public function isPatch()
    {
        return $this->isVerb('patch');
    }

    /**
     * Gibt zurück, ob es sich bei dem aktuellen HTTP-Request um einen PUT-Request
     * handelt.
     *
     * @return bool
     */
    public function isPut()
    {
        return $this->isVerb('put');
    }

    /**
     * Gibt zurück, ob es sich bei dem aktuellen HTTP-Request um einen DELETE-Request
     * handelt.
     *
     * @return bool
     */
    public function isDelete()
    {
        return $this->isVerb('delete');
    }

    /**
     * Prüft ob es sich bei dem aktuellen HTTP-Request um einen bestimmten Request
     * handelt.
     *
     * @param string $verb z.B.: get, post, put, ...
     *
     * @return bool
     */
    public function isVerb($verb)
    {
        return $this->getVerb() == strtolower($verb);
    }

    /**
     * Liefert die $_SERVER['REQUEST_METHOD'] des aktuellen Requests (lowercase).
     *
     * @return string
     */
    public function getVerb()
    {
        if (isset($this->server)) {
            return strtolower($this->server->get('REQUEST_METHOD'));
        }
    }

    /**
     * Gibt die akzeptierten Formate (MIME) der HTTP-Anfrage zurück (HTTP_ACCEPT).
     *
     * @return array
     */
    public function getAccept()
    {
        $accept = array();
        if (isset($this->server)) {
            $parts = explode(',', $this->server->get('HTTP_ACCEPT'));
            foreach ($parts as $part) {
                $type_parts = explode(';', $part);
                $type = $type_parts[0];
                if ($type != '*/*') {
                    $accept[] = $type;
                }
            }
        }

        return $accept;
    }

    /**
     * Prüft ob die übergebene Request-Methode gültig ist.
     *
     * @param string $verb z.B.: get, post, put, ...
     *
     * @return bool
     */
    public static function isValidVerb($verb)
    {
        return in_array(strtolower($verb), self::$verbs);
    }

    /**
     * Gibt zurück ob sich das Request-Objekt in einem gültigen Zustand ist.
     *
     * @return bool
     */
    public function isValid()
    {
        return self::isValidVerb($this->getVerb());
    }
}
