<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend\Json;

/**
 * Class JsonIgnore
 * @package Kore\Layout\Element\Frontend\Json
 */
class JsonIgnore extends JsonAbstract
{
    /**
     * @return array
     */
    public function toArray():array
    {
        return [];
    }
}
