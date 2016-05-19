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

    /**
     * Beinhaltet die registrieren "Informationen", wie z.B.: Session, Cookie, usw.
     * eines eigegangenen HTTP-Requests.
     *
     * @var array
     */
    private $container = array();

    /**
     * Erzeugt eine neue Request-Instanz.
     */
    public function __construct()
    {
        $this->register('cookie', new Cookie());
        $this->register('get', new Get());
        $this->register('server', new Server());
        $this->register('session', new Session());
        if ($this->isPost()) {
            $this->register('post', new Post());
        }
    }

    /**
     * Registriert ein neues Objekt im Request.
     *
     * @param string $name Name des Objektes und dem es "angesprochen" werden soll.
     * @param mixed  $obj  Eigentliches Objekt, das eingefügt werden soll.
     */
    private function register($name, $obj)
    {
        $this->container[$name] = $obj;
    }

    /**
     * Prüft ob ein Objekt hinter dem angegebenen Namen hinterlegt ist.
     *
     * @param string $name Name des Objektes, nachdem gesucht werden soll.
     *
     * @return bool
     */
    private function hasObject($name)
    {
        return array_key_exists($name, $this->container);
    }

    /**
     * Entfernt ein bereits bestehendes Objekt, sofern es existiert.
     *
     * @param string $name Name des Objektes, das entfernt werden soll.
     *
     * @return bool
     */
    private function unregister($name)
    {
        if ($this->hasObject($name)) {
            unset($this->container[$name]);

            return true;
        }

        return false;
    }

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

    /**
     * Gibt das jeweilige Objekt des Requests zurück, sofern es existiert.
     *
     * @param string $name Name des Objektes
     *
     * @return mixed
     */
    public function __get($name)
    {
        if ($this->hasObject($name)) {
            return $this->container[$name];
        }
    }

    /**
     * Registriert ein neues Objekt im Request.
     *
     * @param string $name Name des Objektes und dem es "angesprochen" werden soll.
     * @param mixed  $obj  Eigentliches Objekt, das eingefügt werden soll.
     */
    public function __set($name, $obj)
    {
        $this->register($name, $obj);
    }

    /**
     * Prüft ob ein Objekt hinter dem angegebenen Namen hinterlegt ist.
     *
     * @param string $name Name des Objektes, nachdem gesucht werden soll.
     *
     * @return bool
     */
    public function __isset($name)
    {
        return $this->hasObject($name);
    }

    /**
     * Entfernt ein bereits bestehendes Objekt, sofern es existiert.
     *
     * @param string $name Name des Objektes, das entfernt werden soll.
     *
     * @return bool
     */
    public function __unset($name)
    {
        $this->unregister($name);
    }
}
