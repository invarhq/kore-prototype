<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Utils\Debug;

/**
 * Trait DebugTrait
 * @package Kore\Utils
 */
class DummyDebug implements DebugInterface
{
    /**
     * @param string $name
     * @param null $label
     */
    public function startDebugMeasure($name, $label = null)
    {
        // TODO: Implement debuger
    }

    /**
     * @param string $label
     * @param int $start
     * @param int $end
     */
    public function addDebugMeasure($label, $start, $end)
    {
        // TODO: Implement debuger
    }

    /**
     * @param string $name
     */
    public function stopDebugMeasure($name)
    {
        // TODO: Implement debuger
    }
}