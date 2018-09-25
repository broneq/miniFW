<?php

use MiniFw\Lib\Di;

error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__ . '../Lib/Autoloader.php';
$autoloader = new \MiniFw\Lib\Autoloader();
$autoloader->registerNamespace('MiniFw', __DIR__ . '/..');
$autoloader->registerNamespace('MiniFwSample', __DIR__);
$auth = new MiniFw\Lib\Auth;
$router = new \MiniFw\Lib\Router('MiniFwSample\Controller');

$auth->addUser('admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'); //pass: 1234
$auth->authRequest();

Di::register('auth', $auth);
Di::register('router', $router);
Di::register('db', new \MiniFw\Lib\Db(__DIR__ . '/db.sqlite'));
Di::register('view', new \MiniFw\Lib\View(__DIR__ . '/tpl'));
$router->registerNotFoundAction(function () {
    header("HTTP/1.0 404 Not Found");
    echo "Page not found.\n";
    die();
});
$router->registerDefaultController('index');
$router->handle($_GET);
