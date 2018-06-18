<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Backend;

use Kore\Layout\Element\DataTransport\ElementData;

/**
 * Class BackendDefault
 * @package Kore\Layout\Element\Backend
 */
class BackendDefault extends BackendAbstract
{
    /**
     * @param ElementData $data
     * @return BackendInterface
     */
    public function prepare(ElementData $data): BackendInterface
    {
        return $this;
    }

    /**
     * @param ElementData $data
     * @return BackendInterface
     */
    public function process(ElementData $data): BackendInterface
    {
        return $this;
    }
}
