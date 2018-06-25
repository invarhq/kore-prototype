<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Template\ProcessorResolver;

use Kore\Layout\Element\Template\Processor\ProcessorInterface;

/**
 * Class ProcessorResolver
 * @package Kore\Layout\Element\Template\ProcessorResolver
 */
class ProcessorResolver implements ProcessorResolverInterface
{
    /** @var array */
    protected $processors = [];

    /**
     * @param string $code
     * @param ProcessorInterface $processor
     * @return $this
     */
    public function setProcessor(string $code, ProcessorInterface $processor)
    {
        $this->processors[$code] = $processor;

        return $this;
    }

    /**
     * @param iterable|array|ProcessorInterface[] $processors
     */
    public function setProcessors(iterable $processors)
    {
        foreach ($processors as $processor) {
            if ($processor instanceof ProcessorInterface) {
                foreach ($processor->getExtensionCodes() as $code) {
                    $this->setProcessor($code, $processor);
                }
            }
        }
    }

    /**
     * @param string $code
     * @return ProcessorInterface
     * @throws ProcessorResolverException
     */
    public function resolve(string $code):ProcessorInterface
    {
        if (!array_key_exists($code, $this->processors)) {
            throw new ProcessorResolverException("Can't resolve processor for '{$code}'");
        }

        return $this->processors[$code];
    }
}
