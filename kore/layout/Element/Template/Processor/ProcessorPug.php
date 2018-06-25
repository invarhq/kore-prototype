<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Template\Processor;

use Kore\Utils\ServiceProxyAbstract;
use Pug\Pug;

/**
 * Class ProcessorPug
 * @package Kore\Layout\Element\Template\Processor
 */
class ProcessorPug implements ProcessorInterface
{
    protected $pug;

    /**
     * @return array
     */
    public function getExtensionCodes(): array
    {
        return ['pug', 'jade'];
    }

    /**
     * TemplateProcessor constructor.
     * @param ServiceProxyAbstract $locator
     * @param ServiceProxyAbstract $loader
     * @param string $baseDir
     */
    public function __construct(ServiceProxyAbstract $locator, ServiceProxyAbstract $loader, string $baseDir)
    {
        $this->pug = new Pug([
            'base_dir' => $baseDir,
            'locator_class_name' => get_class($locator),
            'get_file_contents' => $loader,
        ]);
    }

    /**
     * @param string $template
     * @param iterable|null $vars
     * @return string
     * @throws \Exception
     */
    public function processTemplate(string $template, iterable $vars = null): string
    {
        return $this->pug->renderFile($template, $vars ? $vars : []);
    }

    /**
     * @return bool
     */
    public function isJsCompatible(): bool
    {
        return true;
    }
}
