<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Backend;

use Kore\Layout\Element\DataTransport\ElementData;

/**
 * Interface BackendInterface
 * @package Kore\Layout\Element\Backend
 */
interface BackendInterface
{
    /**
     * @param ElementData $data
     * @return BackendInterface
     */
    public function prepare(ElementData $data):BackendInterface;

    /**
     * @param ElementData $data
     * @return BackendInterface
     */
    public function process(ElementData $data):BackendInterface;
}
