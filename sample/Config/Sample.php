<?php


namespace MiniFwSample\Config;


use MiniFw\Lib\Auth;
use MiniFw\Lib\Db;
use MiniFw\Lib\Di\BaseConfig;
use MiniFw\Lib\Di\Dependency;
use MiniFw\Lib\Router;
use MiniFw\Lib\View;

class Sample extends BaseConfig
{
    /**
     * Sample constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->addDependency((new Dependency('auth', Auth::class))
            ->addCall('addUser', 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef') //123
            ->addCall('authRequest'));
        //
        $this->addDependency((new Dependency('router', Router::class))
            ->addParameter('MiniFwSample\Controller\\')
            ->addCall('registerNotFoundAction', function () {
                header("HTTP/1.0 404 Not Found");
                echo "Page not found.\n";
                die();
            })
            ->addCall('registerDefaultController', 'index')
            ->addCall('handle', $_GET)
        );
        //
        $this->addDependency((new Dependency('db', Db::class))
            ->addParameter(__DIR__ . '/../db.sqlite'));
        //
        $this->addDependency((new Dependency('view', View::class))
            ->addParameter(__DIR__ . '/../tpl'));
        //
        //
        $this->autorun('auth');
        $this->autorun('router');
        $this->autorun('view');
        //
        $this->build();
    }
}