<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Template\Processor;

use Twig\Environment;

/**
 * Class ProcessorTwig
 * @package Kore\Layout\Element\Template\Processor
 */
class ProcessorTwig implements ProcessorInterface
{
    protected $twig;

    /**
     * TemplateProcessor constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return array
     */
    public function getExtensionCodes(): array
    {
        return ['twig'];
    }

    /**
     * @param string $template
     * @param iterable|null $vars
     * @return string
     * @throws \Exception
     */
    public function processTemplate(string $template, iterable $vars = null): string
    {
        return $this->twig->render($template, $vars ? $vars : []);
    }

    /**
     * @return bool
     */
    public function isJsCompatible(): bool
    {
        return true;
    }
}
