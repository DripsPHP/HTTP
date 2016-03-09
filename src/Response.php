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
     * Beinhaltet den HTTP-Statuscode der zurückgegeben werden soll.
     * 200 = OK.
     *
     * @var int
     */
    public $status = 200;

    /**
     * Beinhaltet den eigentlichen Body bzw. Inhalt des HTTP-Responses.
     *
     * @var string
     */
    public $body = '';

    /**
     * Beinhaltet die Header-Felder die  gesetzt werden sollen (beim Response).
     *
     * @var array
     */
    protected $headers = array(
        'Content-Type' => 'text/html',
        'Cache-Control' => 'max-age=0',
    );

    /**
     * Gibt an, ob bereits ein Response gesendet wurde oder nicht.
     *
     * @var bool
     */
    private static $sent = false;

    /**
     * Fügt ein weiteres HTTP-Response-Header-Feld hinzu, sofern dies noch möglich
     * ist. (wenn noch keine Header gesendet wurden).
     *
     * @param string $name  Name des Header-Feldes, z.B.: Content-Type
     * @param string $value Wert des Header-Feldes, z.B.: text/html
     */
    public function setHttpHeader($name, $value)
    {
        if (!headers_sent()) {
            header("$name: $value");
        }
    }

    /**
     * Setzt die Header-Informationen für einen Response (HTTP).
     *
     * @param string $name  Name des Header-Feldes, z.B.: Content-Type
     * @param string $value Wert des Header-Feldes, z.B.: text/html
     */
    public function setHeader($name, $value)
    {
        $this->headers[$name] = $value;
    }

    /**
     * Entfernt das übergebene Header-Feld sofern dieses existiert.
     *
     * @param string $name Name des Response-Header-Feldes
     */
    public function unsetHeader($name)
    {
        if (array_key_exists($name, $this->headers)) {
            unset($this->headers[$name]);
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
        if(!static::isSent()){
            foreach ($this->headers as $header => $value) {
                $this->setHttpHeader($header, $value);
            }
            http_response_code($this->status);
            echo $this->body;
            static::$sent = true;
            return true;
        }
        return false;
    }

    /**
     * Gibt an ob bereits ein Response gesendet wurde oder nicht.
     *
     * @return bool
     */
    public static function isSent()
    {
        return static::$sent;
    }
}
