<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Config;

/**
 * Interface ParserInterface
 * @package Kore\Layout\Config
 */
interface SupplierInterface
{
    /**
     * @return array
     */
    public function getConfig():array;
}
