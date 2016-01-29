# HTTP

[![Build Status](https://travis-ci.org/Prowect/HTTP.svg)](https://travis-ci.org/Prowect/HTTP)
[![Code Climate](https://codeclimate.com/github/Prowect/HTTP/badges/gpa.svg)](https://codeclimate.com/github/Prowect/HTTP)
[![Test Coverage](https://codeclimate.com/github/Prowect/HTTP/badges/coverage.svg)](https://codeclimate.com/github/Prowect/HTTP/coverage)
[![Latest Release](https://img.shields.io/packagist/v/drips/HTTP.svg)](https://packagist.org/packages/drips/http)

## Session

### Beschreibung

Das Session-System ermöglich das Speichern zusätzlicher Informationen für Session-Variablen. So können beispielsweise Session-Variablen mit der Zeit ablaufen.

### Installation

1. Zuerst muss die `session.php` included werden.
2. Anschließend muss ein `Session`-Objekt angelegt werden.

> Das `Session`-Objekt sollte bei jedem Aufruf erzeugt werden.

### Verwendung

Jedes Session-Objekt verfügt über einen eigenen Speicherbereich innerhalb der Session. Durch die Angabe eines Namens bzw. einer ID wird ein Speicherbereich für das jeweilige Objekt angelegt. Dementsprechend ist es auch möglich, dass mehrere Objekte, den gleichen Speicherbereich verwalten, wenn Sie über den gleichen Namen verfügen. Dies ist allerdings nicht zu empfehlen!

```php
<?php
use Drips\HTTP\Session;
require_once 'session.php';
$session = new Session("Name_Der_Session");
```

Nachdem das `Session`-Objekt angelegt wurde, können Daten innerhalb der Session gespeichert und ausgelesen werden.

### Speichern von Daten

```php
<?php
$session->set("key", 3);
```

Über die `set`-Methode kann ein Wert unter einem bestimmten Schlüssel hinterlegt werden.
Der Wert wird automatisch serialisiert wenn es sich dabei um ein Objekt handelt.
Außerdem kann ein weiterer Parameter angegeben werden. Wird `true` als 3. Parameter übergeben, so läuft die Session-Variable mit dem Ende des nächsten Seitenaufrufs ab. (Somit können Daten zwischen 2 Seiten übertagen werden)

### Auslesen von Daten

```php
<?php
$value = $session->get("key");
```

Die `get`-Methode fragt über den übergebenen Schlüssel den dazugehörigen Wert ab. (Sofern der Schlüssel bereits registriert ist)

Es können auch alle Session-Informationen des Objektes abgefragt werden:

```php
<?php
$data = $session->getAll();
```
