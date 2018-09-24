<?php
/**
 * Created by PhpStorm.
 * User: przem
 * Date: 23.09.2018
 * Time: 18:50
 */

namespace MiniFw\Lib;


class View
{
    /**
     * @var string
     */
    private $templateDir;

    /**
     * View constructor.
     * @param string $templateDir
     */
    public function __construct(string $templateDir)
    {
        $this->templateDir = $templateDir;
    }

    /**
     * Renders template
     * @param string $template
     * @param array $variables
     */
    public function render(string $template, array $variables = []): void
    {
        include rtrim($this->templateDir, '/') . '/' . $template . '.phtml';
    }
}