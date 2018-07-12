<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Processor;

use Kore\Layout\Element\DataTransport\ElementData;
use Kore\Layout\Element\Frontend\FrontendInterface;
use Kore\Utils\Arrayable;

/**
 * Class ProcessorJson
 * @package Layout\Processor
 */
class ProcessorJson extends ProcessorAbstract
{

    /**
     * @param Arrayable|FrontendInterface $frontend
     * @param ElementData $elementData
     * @return array|mixed|null
     */
    protected function processFrontendOutput(FrontendInterface $frontend, ElementData $elementData)
    {
        $output = null;

        if ($frontend instanceof Arrayable) {
            $frontend->setElementData($elementData);
            $output = $frontend->toArray();
        }

        return $output;
    }
}
