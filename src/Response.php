<?php

/**
 * Created by Prowect
 * Author: Raffael Kessler
 * Date: 21.02.2016 - 12:30.
 * Copyright Prowect.
 */
namespace Drips\HTTP;

/**
 * Class Response.
 *
 * Diese Klasse dient zum Erzeugen und Senden eines vollständigen HTTP-Responses
 */
class Response
{
    /**
     * Beinhaltet die Response-Instanz (Singleton-Pattern).
     *
     * @var Response
     */
    private static $instance;

    /**
     * Speichert ob bereits ein Response gesendet wurde oder nicht.
     *
     * @var bool
     */
    private $sent = false;

    /**
     * Beinhaltet den Content-Type des HTTP-Responses.
     *
     * @var string
     */
    protected $type = 'text/html';

    /**
     * Beinhaltet den HTTP-Statuscode der zurückgegeben werden soll.
     * 200 = OK
     *
     * @var int
     */
    protected $status = 200;

    /**
     * Beinhaltet Caching-Informationen (Cache-Control)
     *
     * @var string
     */
    protected $cache = 'max-age=0';

    /**
     * Beinhaltet den eigentlichen Body bzw. Inhalt des HTTP-Responses.
     *
     * @var string
     */
    protected $body = '';

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __destruct()
    {
        $this->send();
    }

    /**
     * Setzt den Body bzw. Inhalt des Responses.
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Liefert den aktuellen Body bzw. Inhalt des Responses zurück.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Fügt ein weiteres HTTP-Response-Header-Feld hinzu, sofern dies noch möglich
     * ist. (wenn noch keine Header gesendet wurden)
     *
     * @param string $name Name des Header-Feldes, z.B.: Content-Type
     * @param string $value Wert des Header-Feldes, z.B.: text/html
     */
    public function setHeader($name, $value)
    {
        if (!headers_sent()) {
            header("$name: $value");
        }
    }

    /**
     * Bastelt den Response zusammen und sendet diesen ab, sofern er noch nicht
     * abgesendet wurde.
     *
     * @return bool
     */
    public function send()
    {
        if (!$this->isSent()) {
            $this->sent = true;
            $this->setHeader('Content-Type', $this->type);
            $this->setHeader('Cache-Control', $this->cache);
            http_response_code($this->status);
            echo $this->getBody();

            return true;
        }

        return false;
    }

    /**
     * Gibt zurück, ob der Response bereits abgesendet wurde.
     *
     * @return bool
     */
    public function isSent()
    {
        return $this->sent;
    }

    /**
     * Erzeugt eine neue Instanz eines Response-Objektes bzw. liefert das bestehende
     * zurück. (Singleton-Pattern).
     *
     * @return Response
     */
    public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new self();
        }

        return static::$instance;
    }
}
