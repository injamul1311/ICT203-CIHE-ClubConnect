<?php
declare(strict_types=1);

define('APP_NAME', 'CIHE ClubConnect');
define('DB_HOST', 'localhost');
define('DB_NAME', 'cihe_clubconnect');
define('DB_USER', 'root');
define('DB_PASS', '');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
