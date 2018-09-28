<?php

namespace MiniFw\Lib;
use MiniFw\Lib\Di\Dependency;
use MiniFw\Lib\Di\DependencyFactory;

/**
 * Class Di
 * @package MiniFw\Lib
 */
class Di
{
    private static $di = [];


    public static function registerDependency(Dependency $dependency) {
        self::$di[$dependency->getName()] = $dependency;
    }
    /**
     * Register class in DI
     * @param string $name
     * @param mixed $class
     * @deprecated - use registerDependency
     */
    public static function register(string $name, $class): void
    {
        self::$di[$name] = $class;
    }

    /**
     * Get registered class from DI
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public static function get(string $name)
    {
        if (self::$di[$name]) {
            DependencyFactory::build(static::$di[$name]);
        }
        throw new \Exception('Service named :'.$name.' not found!');
    }
}