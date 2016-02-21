<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 21.02.2016 - 12:30.
 * Copyright Prowect.
 */
namespace Drips\HTTP;

use ArrayAccess;

/**
 * Class Request.
 *
 * Diese Klasse dient als Container für Session, Get, Post, Server, Cookie, usw.
 * Außerdem enthält sie Informationen zum eigegangenen HTTP-Request.
 */
class Request implements ArrayAccess
{
    /**
     * Beinhaltet die Request-Instanz (Singleton-Pattern).
     *
     * @var Request
     */
    private static $instance = null;

    /**
     * Beinhaltet die registrieren "Informationen", wie z.B.: Session, Cookie, usw.
     * eines eigegangenen HTTP-Requests.
     *
     * @var array
     */
    protected $container = array();

    /**
     * Erzeugt eine neue Instanz eines Request-Objektes bzw. liefert das bestehende
     * zurück. (Singleton-Pattern).
     *
     * @return Request
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Registriert ein neues Objekt im Request.
     *
     * @param string $name Name des Objektes und dem es "angesprochen" werden soll.
     * @param mixed  $obj  Eigentliches Objekt, das eingefügt werden soll.
     */
    public function register($name, $obj)
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
    public function hasObject($name)
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
    public function unregister($name)
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
        return strtoupper($this->container['server']->get('REQUEST_METHOD')) == strtoupper($verb);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    private function __construct()
    {
        $this->register('cookie', new Cookie());
        $this->register('get', new Get());
        $this->register('server', new Server());
        $this->register('session', new Session());
        if ($this->isPost()) {
            $this->register('post', new Post());
        }
    }

    private function __clone()
    {
    }
}
