<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 02.11.2015 - 10:00
 * Copyright: Prowect.
 */
namespace Drips\HTTP;

use Drips\DataStructures\IDataCollection;

/**
 * Class Session.
 *
 * $_SESSION mit erweiterter Funktionalität und erhöhter Sicherheit.
 */
class Session implements IDataCollection
{
    /**
     * Beinhaltet eine ID unter der die Session-Daten gespeichert werden.
     *
     * @var string
     */
    private $id;

    /**
     * Beinhaltet eine ID unter der id Informationen zu den Session-Daten
     * gespeichert werden.
     *
     * @var string
     */
    private $id_info;

    /**
     * Beinhaltet die Session-Daten
     *
     * @var array
     */
    private $collection = array();

    /**
     * Erzeugt eine neue Session-Instanz.
     * Es sollte bei jedem Seitenaufruf ein solches Session-Objekt angelegt
     * werden, damit die Session-Informationen auch entsprechend wieder entfernt
     * werden können.
     *
     * @param string $id Die ID unter der die Session-Daten gespeichert werden sollen
     */
    public function __construct($id = 'DRIPS')
    {
        session_name($id);
        $this->id = $id;
        $this->id_info = $this->id.'_INFO';
        if (session_status() != PHP_SESSION_ACTIVE && !headers_sent()) {
            session_start();
        }
        $this->collection = @$_SESSION;
        $this->cleanup();
    }

    /**
     * Dient zum "Aufräumen" der Session-Information. Löscht veraltete oder
     * abgelaufene Session-Informationen.
     */
    private function cleanup()
    {
        if (isset($this->collection[$this->id_info])) {
            foreach ($this->collection[$this->id_info] as $key => $val) {
                $expire = $this->getSessionInfo($key, 'expire');
                if ($expire) {
                    $this->setSessionInfo($key, 'expire', -1);
                } elseif ($expire == -1) {
                    $this->delete($key);
                }
            }
        }
    }

    /**
     * Führt beim Beenden des Scripts bzw. beim "Beenden" der Session ein cleanup
     * durch.
     */
    public function __destruct()
    {
        $this->cleanup();
        $_SESSION = $this->collection;
    }

    /**
     * Überprüft ob in der Session ein Wert unter dem Schlüssel $key hinterlegt
     * ist.
     *
     * @param string $key Schlüssel nach dem gesucht werden soll
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->collection[$this->id][$key]);
    }

    /**
     * Gibt den Wert der Session eines zugehörigen Schlüssels zurück.
     * Sofern der Schlüssel nicht existiert wird NULL zurückgeliefert.
     *
     * @param string $key Schlüssel nach dem gesucht werden soll
     *
     * @return mixed
     */
    public function get($key)
    {
        if ($this->has($key)) {
            $val = $this->getSession($key);
            $unserialized = @unserialize($val);
            if ($unserialized !== false) {
                return $unserialized;
            }

            return $val;
        }

        return;
    }

    /**
     * Liefert alle Session-Daten dieses Objektes zurück.
     *
     * @return mixed
     */
    public function getAll()
    {
        if (isset($this->collection[$this->id])) {
            return $this->collection[$this->id];
        }

        return array();
    }

    /**
     * Setzt einen Wert in der Session.
     *
     * @param string $key    Der Schlüssel hinter dem die Information hinterlegt werden soll
     * @param mixed  $val    Der Wert der in der Session gespeichert werden soll
     */
    public function set($key, $val)
    {
        if (is_object($val)) {
            $val = serialize($val);
        }
        $this->setSession($key, $val);
    }

    /**
     * Setzt einen Wert in der Session, der beim Aufruf der nächsten Seite
     * wieder gelöscht wird.
     *
     * @param  string $key  Der Schlüssel hinter dem die Information hinterlegt werden soll
     * @param  mixed  $val  Der Wert der in der Session gespeichert werden soll
     */
    public function flash($key, $val)
    {
        $this->set($key, $val);
        $this->setSessionInfo($key, 'expire', true);
    }

    /**
     * Entfernt den gesetzten Wert, sofern er bereits vorhanden ist.
     *
     * @param string $key Der Schlüssel der gelöscht werden soll
     *
     * @return bool
     */
    public function delete($key)
    {
        if ($this->has($key)) {
            unset($this->collection[$this->id_info][$key]);
            unset($this->collection[$this->id][$key]);

            return true;
        }

        return false;
    }

    /**
     * Zuständig für den direkten Zugriff auf die Session.
     * Setzt einen Wert für einen zugehörigen Schlüssel.
     *
     * @param string $key Der Schlüssel hinter dem die Information hinterlegt werden soll
     * @param mixed  $val Der Wert der in der Session gespeichert werden soll
     */
    private function setSession($key, $val)
    {
        $this->collection[$this->id][$key] = $val;
    }

    /**
     * Dient zum Setzen von Zusatzinformationen für die Session-Daten.
     *
     * @param string $key  Der Schlüssel für die dazugehörige Session-Information
     * @param string $name Der Name der Zusatzinformation
     * @param mixed  $val  Der Wert der Zusatzinformation
     */
    private function setSessionInfo($key, $name, $val)
    {
        if ($this->has($key)) {
            $this->collection[$this->id_info][$key][$name] = $val;
        }
    }

    /**
     * Dient zum direkten Zugriff auf die Session und liefert den Wert eines
     * dazugehörigen Schlüssels.
     *
     * @param string $key Der Schlüssel hinter dem die Session-Information hinterlegt ist
     *
     * @return mixed
     */
    private function getSession($key)
    {
        return isset($this->collection[$this->id][$key]) ? $this->collection[$this->id][$key] : null;
    }

    /**
     * Dient zum Auslesen der Zusatzinformationen der Session-Daten.
     * Wird kein Name angegeben so werden alle Zusatzinformationen der Session-
     * Daten zurückgeliefert.
     *
     * @param string $key  Der Schlüssel für die dazugehörige Session-Information
     * @param string $name Der Name der Zusatzinformation
     *
     * @return mixed
     */
    private function getSessionInfo($key, $name = null)
    {
        if ($this->has($key)) {
            if ($name == null) {
                return $this->collection[$this->id_info][$key];
            }

            return $this->collection[$this->id_info][$key][$name];
        }

        return;
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetUnset($offset)
    {
        $this->delete($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
}
