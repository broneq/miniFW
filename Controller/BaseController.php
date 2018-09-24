<?php

namespace MiniFw\Controller;


use MiniFw\Lib\Di;
use MiniFw\Lib\Router;
use MiniFw\Lib\View;

abstract class BaseController
{
    /**
     * @var Router
     */
    protected $router;
    /**
     * @var View
     */
    protected $view;

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->router = Di::get('router');
        $this->view = Di::get('view');
    }
}