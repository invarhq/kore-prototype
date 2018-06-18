<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend\Json;

use Kore\Utils\Arrayable;

/**
 * Interface JsonInterface
 * @package Kore\Layout\Element\Frontend\Json
 */
interface JsonInterface extends Arrayable
{
    /**
     * @return array
     */
    public function toArray():array;
}
