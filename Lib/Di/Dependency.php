<?php


namespace MiniFw\Lib\Di;

/**
 * Class Service
 * @package MiniFw\Lib\Di
 */
class Dependency
{
    /**
     * @var string
     */
    private $className;
    /**
     * @var array
     */
    private $injectables = [];
    /**
     * @var string
     */
    private $name;

    /**
     * Service constructor.
     * @param string $name
     * @param string $className
     */
    public function __construct(string $name, string $className)
    {
        $this->className = $className;
        $this->name = $name;
    }

    /**
     * Add service dependency
     * @param string $serviceName
     * @return Dependency
     */
    public function addService(string $serviceName): self
    {
        $this->injectables[] = [
            'type' => 'service',
            'name' => $serviceName
        ];
        return $this;
    }

    /**
     * Adds parameter to dependency
     * @param $value
     * @return Dependency
     */
    public function addParameter($value): self
    {
        $this->injectables[] = [
            'type' => 'parameter',
            'value' => $value
        ];
        return $this;
    }

    /**
     * Adds a call for a method
     * @param string $methodName
     * @param mixed ...$parameters
     * @return Dependency
     */
    public function addCall(string $methodName, ...$parameters): self
    {
        $this->injectables[] = [
            'type' => 'call',
            'method' => $methodName,
            'parameters' => $parameters
        ];
        return $this;
    }

    /**
     * gets name of dependency
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets dependency class name
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * Returns an injectables for dependency
     * @return array
     */
    public function getInjectables(): array
    {
        return $this->injectables;
    }
}

