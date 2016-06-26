<?php

if (session_status() != PHP_SESSION_ACTIVE && !headers_sent() && PHP_SAPI != 'cli') {
    session_start();
}
