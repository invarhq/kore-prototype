<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Utils\Debug;

/**
 * Interface DebugInterface
 * @package Kore\Utils
 */
interface DebugInterface
{
    /**
     * @param string $name
     * @param null $label
     */
    public function startDebugMeasure($name, $label = null);

    /**
     * @param string $label
     * @param int $start
     * @param int $end
     */
    public function addDebugMeasure($label, $start, $end);

    /**
     * @param string $name
     */
    public function stopDebugMeasure($name);
}