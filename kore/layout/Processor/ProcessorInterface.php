<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

/** {license_text}  */

namespace Kore\Layout\Processor;

use Kore\Layout\ConfigInterface;

/**
 * Interface ProcessorInterface
 * @package Kore\Layout\Processor
 */
interface ProcessorInterface
{
    /**
     * @param ConfigInterface $layoutConfig
     * @return mixed
     */
    public function process(ConfigInterface $layoutConfig);
}
