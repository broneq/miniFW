<?php

namespace MiniFw\Lib;


/**
 * Class Router
 * @package MiniFw\Lib
 */
class Router
{
    /**
     * @var array
     */
    private $params = [];
    /**
     * @var callable
     */
    private $notFoundAction;
    /**
     * @var string
     */
    private $controller;
    /**
     * @var string
     */
    private $action = 'index';
    /**
     * @var string
     */
    private $controllerNamespace;

    /**
     * Router constructor.
     * @param string $controllerNamespace
     */
    public function __construct($controllerNamespace = 'MiniFw\Controller')
    {
        $this->controllerNamespace = $controllerNamespace;
    }

    /**
     * Handle route
     * @param array $params
     */
    public function handle(array $params)
    {
        $this->params = $params;
        $this->setControler($params);
        $this->setAction($params);
        $this->setParams($params);
        $this->resolve();
    }

    public function redirect(string $controller, string $action, array $params = []): void
    {
        header('Location: ?controller=' . $controller . '&action=' . $action . '&' . http_build_query($params));
    }

    /**
     * Returns parameter
     * @param string $name
     * @return mixed|null
     */
    public function getParam(string $name)
    {
        return $this->params[$name] ?? null;
    }

    /**
     * Registers Default Controller
     * @param string $name
     */
    public function registerDefaultController(string $name): void
    {
        $this->controller = $name;
    }

    /**
     * Registers Not Found Function
     * @param callable $fn
     */
    public function registerNotFoundAction(callable $fn): void
    {
        $this->notFoundAction = $fn;
    }

    /**
     * Resolves route
     */
    private function resolve(): void
    {
        try {
            //@todo missing exception for missing controller
            $className = rtrim($this->controllerNamespace,'\\') . '\\' . $this->controller;
            $controller = new $className();
            if (!method_exists($controller, $this->action . 'Action')) {
                throw new \RuntimeException('Action not found');
            }
            $controller->{$this->action . 'Action'}();
        } catch (\RuntimeException $exception) {
            $action = $this->notFoundAction;
            $action();
        }
    }

    /**
     * Sets controller from params
     * @param array $params
     */
    private function setControler(array $params)
    {
        $this->controller = ucfirst(isset($params['controller']) ? $params['controller'] : $this->controller);
    }

    /**
     * Sets action from params
     * @param array $params
     */
    private function setAction(array $params)
    {
        $this->action = (isset($params['action'])) ? $params['action'] : $this->action;
    }

    /**
     * Sets params from params
     * @param array $params
     */
    private function setParams(array $params)
    {
        unset($params['controller']);
        unset($params['action']);
        $this->params = $params;
    }
}