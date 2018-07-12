<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Processor;

use Kore\Layout\Element\DataTransport\ElementData;
use Kore\Layout\Element\Frontend\FrontendInterface;
use Kore\Utils\Htmlable;

/**
 * Class ProcessorJson
 * @package Layout\Processor
 */
class ProcessorHtml extends ProcessorAbstract
{

    /**
     * @param Htmlable|FrontendInterface $frontend
     * @param ElementData $elementData
     * @return mixed|string
     */
    protected function processFrontendOutput(FrontendInterface $frontend, ElementData $elementData)
    {
        $output = '';

        if ($frontend instanceof Htmlable) {
            $frontend->setElementData($elementData);
            $output = $frontend->toHtml();
        }

        return $output;
    }
}
