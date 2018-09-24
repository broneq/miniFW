<?php

namespace MiniFw\Lib;

/**
 * Class Autoloader
 * @package MiniFw\Lib
 */
class Autoloader
{
    /**
     * Registers namespace autoloader
     * @param string $namespace
     * @param string $directory
     */
    public function registerNamespace(string $namespace,string $directory): void
    {
        spl_autoload_register(function ($class) use ($namespace,$directory) {

            // project-specific namespace prefix
            $prefix = $namespace;

            // base directory for the namespace prefix
            $base_dir = $directory;

            // does the class use the namespace prefix?
            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {
                // no, move to the next registered autoloader
                return;
            }

            // get the relative class name
            $relative_class = substr($class, $len);

            // replace the namespace prefix with the base directory, replace namespace
            // separators with directory separators in the relative class name, append
            // with .php
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            // if the file exists, require it
            if (file_exists($file)) {
                require $file;
            }
        });
    }
}