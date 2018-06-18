<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

/** {license_text}  */

namespace Kore\Layout;

/**
 * Interface ConfigInterface
 * @package Kore\Layout
 */
interface ConfigInterface
{
    /**
     * @param array $handles
     * @param bool $includeDefaultHandle
     * @return mixed
     */
    public function load($handles = [], $includeDefaultHandle = true);

    /**
     * @param $target
     * @return mixed
     */
    public function setTarget($target);

    /**
     * @return mixed
     */
    public function toArray();
}
