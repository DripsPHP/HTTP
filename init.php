<?php

if (session_status() != PHP_SESSION_ACTIVE && !headers_sent()) {
    session_start();
}
