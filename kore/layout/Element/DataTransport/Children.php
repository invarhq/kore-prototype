<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\DataTransport;

use Arrayy\Arrayy;
use function array_merge;

class Children extends Arrayy
{
    /**
     * @param array $array
     * @return $this
     */
    public function concat(array $array)
    {
        $this->array += $array;

        return $this;
    }
}
