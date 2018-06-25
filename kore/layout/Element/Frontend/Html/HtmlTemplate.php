<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend\Html;

use Kore\Layout\Element\Template\ProcessorResolver\ProcessorResolverInterface;

/**
 * Class HtmlText
 * @package Kore\Layout\Element\Frontend\Html
 */
class HtmlTemplate extends HtmlAbstract
{
    protected $templateSource;
    protected $resolver;

    /**
     * HtmlTemplate constructor.
     * @param ProcessorResolverInterface $resolver
     */
    public function __construct(ProcessorResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @return null|string
     */
    protected function getProcessorCode():?string
    {
        if ($processor = $this->getPrivateData('processor')) {
            return $processor;
        }

        return pathinfo($this->getPrivateData('template'), PATHINFO_EXTENSION);
    }

    /**
     * @return string
     */
    public function toHtml():string
    {
        $processor = $this->resolver->resolve($this->getProcessorCode());

        return $processor->processTemplate(
            $this->getPrivateData('template'),
            array_merge($this->getChildResult()->toArray(), $this->toArray())
        );
    }
}
