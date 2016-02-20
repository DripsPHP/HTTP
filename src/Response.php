<?php

namespace Drips\HTTP;

class Response
{
    private static $instance;
    private $sent = false;

    protected $type = "text/html";
    protected $status = 200;
    protected $cache = "max-age=0";
    protected $body = "";

    private function __construct(){}

    private function __clone(){}

    public function __destruct(){
        $this->send();
    }

    public function setBody(){
        $this->body = $body;
    }

    public function getBody(){
        return $this->body;
    }

    public function setHeader($name, $value){
        if(!headers_sent()){
            header("$name: $value");
        }
    }

    public function send(){
        if(!$this->isSent()){
            $this->sent = true;
            $this->setHeader("Content-Type", $this->type);
            $this->setHeader("Cache-Control", $this->cache);
            http_response_code($this->status);
            echo $this->getBody();
            return true;
        }
        return false;
    }

    public function isSent(){
        return $this->sent;
    }

    public static function getInstance(){
        if(!isset(static::$instance)){
            static::$instance = new static;
        }
        return static::$instance;
    }
}
