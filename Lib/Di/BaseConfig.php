<?php


namespace MiniFw\Lib\Di;

use MiniFw\Lib\Di;

/**
 * Class BaseConfig
 * @package MiniFw\Lib\Di
 */
abstract class BaseConfig
{
    /**
     * @var array
     */
    protected $dependencies = [];
    protected $autorun = [];
    protected static $params = [];

    /**
     * Build configuration
     * call on end of configuration
     * @throws \Exception
     */
    public function build(): void
    {
        $this->registerDependencies();
        $this->autorunServices();
    }

    /**
     * Autoruns service
     * @param string $service
     */
    public function autorun(string $service): void
    {
        $this->autorun[] = $service;
    }

    /**
     * Register dependencies
     */
    private function registerDependencies(): void
    {
        foreach ($this->dependencies as $dependency) {
            Di::registerDependency($dependency);
        }
    }

    /**
     * Autorun services
     * @throws \Exception
     */
    private function autorunServices(): void
    {
        foreach ($this->autorun as $autorun) {
            Di::get($autorun);
        }
    }

    /**
     * Adds a configuration parameter
     * @param string $name
     * @param mixed $value
     */
    protected function addParam(string $name, $value): void
    {
        static::$params[$name] = $value;
    }

    /**
     * Adds dependency
     * @param Dependency $dependency
     */
    protected function addDependency(Dependency $dependency): void
    {
        $this->dependencies[] = $dependency;
    }
}