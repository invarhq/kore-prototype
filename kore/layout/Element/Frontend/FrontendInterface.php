<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend;

use Kore\Layout\Element\DataTransport\Children;
use Kore\Layout\Element\DataTransport\ElementData;
use Kore\Layout\Element\DataTransport\PrivateData;
use Kore\Layout\Element\DataTransport\PublicData;
use Kore\Utils\FluentInterface;
use Kore\Utils\Htmlable;

/**
 * Interface FrontendInterface
 * @package Kore\Layout\Element\Frontend
 */
interface FrontendInterface extends FluentInterface, Htmlable
{
    /**
     * @param ElementData $data
     * @return FrontendInterface
     */
    public function setElementData(ElementData $data):FrontendInterface;
}
