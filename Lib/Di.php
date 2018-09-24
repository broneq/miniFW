<?php
/**
 * Created by PhpStorm.
 * User: przem
 * Date: 23.09.2018
 * Time: 12:38
 */

namespace MiniFw\Lib;

/**
 * Class Di
 * @package MiniFw\Lib
 */
class Di
{
    private static $di = [];

    /**
     * Register class in DI
     * @param string $name
     * @param mixed $class
     */
    public static function register(string $name, $class): void
    {
        self::$di[$name] = $class;
    }

    /**
     * Get registered class from DI
     * @param string $name
     * @return mixed
     */
    public static function get(string $name)
    {
        return self::$di[$name];
    }
}