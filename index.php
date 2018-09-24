<?php
/**
 * Created by PhpStorm.
 * User: przem
 * Date: 23.09.2018
 * Time: 11:45
 */

use MiniFw\Lib\Di;

error_reporting(E_ALL);
ini_set('display_errors', 1);
include __DIR__.'/Lib/Autoloader.php';
$autoloader = new \MiniFw\Lib\Autoloader();
$autoloader->registerNamespace('MiniFw', __DIR__);
$auth = new MiniFw\Lib\Auth;
$router = new \MiniFw\Lib\Router();

$auth->addUser('admin', 'sha1');
$auth->authRequest();

Di::register('auth', $auth);
Di::register('router', $router);
Di::register('db', new \MiniFw\Lib\Db(__DIR__ . '/private/matsim.sqlite'));
Di::register('view', new \MiniFw\Lib\View(__DIR__ . '/tpl'));
$router->registerNotFoundAction(function () {
    header("HTTP/1.0 404 Not Found");
    echo "Nie znaleziono strony.\n";
    die();
});
$router->registerDefaultController('inquiry');
$router->handle($_GET);
