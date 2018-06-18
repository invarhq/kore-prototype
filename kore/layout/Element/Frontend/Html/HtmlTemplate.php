<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend\Html;

use Kore\Layout\Element\TemplateProcessorInterface;

/**
 * Class HtmlText
 * @package Kore\Layout\Element\Frontend\Html
 */
class HtmlTemplate extends HtmlAbstract
{
    protected $templateSource;
    protected $templateProcessor;

    /**
     * HtmlTemplate constructor.
     * @param TemplateProcessorInterface $processor
     */
    public function __construct(TemplateProcessorInterface $processor)
    {
        $this->templateProcessor = $processor;
    }

    /**
     * @return string
     */
    public function toHtml():string
    {
        return $this->templateProcessor->processTemplate(
            $this->getPrivateData('template'),
            array_merge($this->getChildResult()->toArray(), $this->toArray())
        );
    }
}
