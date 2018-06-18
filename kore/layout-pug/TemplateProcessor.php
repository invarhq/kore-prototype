<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutPug;

use Kore\Layout\Element\TemplateProcessorInterface;
use Kore\Utils\ServiceProxyAbstract;
use Pug\Pug;

class TemplateProcessor implements TemplateProcessorInterface
{
    protected $pug;

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
}
