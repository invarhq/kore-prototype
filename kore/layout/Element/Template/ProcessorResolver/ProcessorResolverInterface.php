<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Template\ProcessorResolver;

use Kore\Layout\Element\Template\Processor\ProcessorInterface;

/**
 * Interface TemplateProcessorResolverInterface
 * @package Kore\Layout\Element
 */
interface ProcessorResolverInterface
{
    /**
     * @param string $code
     * @param ProcessorInterface $processor
     * @return mixed
     */
    public function setProcessor(string $code, ProcessorInterface $processor);

    /**
     * @param string $code
     * @return ProcessorInterface
     */
    public function resolve(string $code):ProcessorInterface;
}
