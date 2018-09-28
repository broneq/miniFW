<?php

use MiniFw\Lib\Di;
use MiniFwSample\Config\Sample;

error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '../Lib/Autoloader.php';
$autoloader = new \MiniFw\Lib\Autoloader();
$autoloader->registerNamespace('MiniFw', __DIR__ . '/..');
$autoloader->registerNamespace('MiniFwSample', __DIR__);

try {
    new Sample();
} catch (Exception $e) {
    http_response_code(500);
    echo 'FATAL: ' . $e->getMessage();
}
