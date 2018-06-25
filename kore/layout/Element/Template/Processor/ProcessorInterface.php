<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Template\Processor;

/**
 * Interface TemplateSourceInterface
 * @package Kore\LayoutPug
 */
interface ProcessorInterface
{
    /**
     * @param string $template
     * @param iterable|null $vars
     * @return string
     */
    public function processTemplate(string $template, iterable $vars = null):string;

    /**
     * @return array
     */
    public function getExtensionCodes():array;

    /**
     * @return bool
     */
    public function isJsCompatible():bool;
}
