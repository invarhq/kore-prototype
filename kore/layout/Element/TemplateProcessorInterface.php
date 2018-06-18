<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element;

use Kore\Layout\Element\DataTransport\Template;

/**
 * Interface TemplateSourceInterface
 * @package Kore\LayoutPug
 */
interface TemplateProcessorInterface
{
    /**
     * @param string $template
     * @param iterable|null $vars
     * @return string
     */
    public function processTemplate(string $template, iterable $vars = null):string;
}
