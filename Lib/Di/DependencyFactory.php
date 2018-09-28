<?php


namespace MiniFw\Lib\Di;


use MiniFw\Lib\Di;

class DependencyFactory
{
    /**
     * @param Dependency $dependency
     * @return mixed
     * @throws \Exception
     */
    public static function build(Dependency $dependency)
    {
        $parameters = [];
        $calls = [];
        foreach ($dependency->getInjectables() as $injectable) {
            switch ($injectable['type']) {
                case 'service':
                    $parameters[] = static::getService($injectable['name']);
                    break;
                case 'parameter':
                    $parameters[] = $injectable['value'];
                    break;
                case 'call':
                    $calls[] = $injectable['value'];
                    break;
                default:
                    throw new \RuntimeException('No injectable found  type: ' . $injectable['type'] . ' allowed types are service or parameter...');
            }
        }

        $object = static::factorizeObject($dependency->getClassName(), $parameters);

        foreach ($calls as $call) {
            $object->{$call['method']}(...$call['parameters']);
        }
        return $object;
    }

    /**
     * Get serivce
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    private static function getService(string $name)
    {
        return Di::get($name);
    }

    /**
     * Build object with dependecies
     * @param string $className
     * @param array $parametes
     * @return mixed
     */
    private static function factorizeObject(string $className, array $parametes)
    {
        return new $className(...$parametes);
    }
}