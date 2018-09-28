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
     * @var array
     */
    private $calls = [];
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

    public function addCall(string $methodName, array ...$parameters): self
    {
        $this->calls[] = [
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

