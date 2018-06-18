<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Utils;

use ArrayAccess;
use JsonSerializable;
use IteratorAggregate;

/**
 * Interface FluentInterface
 * @package Kore\Utils
 */
interface FluentInterface extends ArrayAccess, JsonSerializable, Arrayable, Jsonable, IteratorAggregate
{
    /**
     * @param array $data
     * @return FluentInterface
     */
    public function setData(array $data = []);
}
