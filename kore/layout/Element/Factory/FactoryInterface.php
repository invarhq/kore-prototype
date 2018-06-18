<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Factory;

use Kore\Layout\Element\ElementInterface;

/**
 * Interface FactoryInterface
 * @package Kore\Layout\Element\Factory
 */
interface FactoryInterface
{
    /**
     * @param string $alias
     * @param string $serviceId
     * @return FactoryInterface
     */
    public function registerElementType(string $alias, string $serviceId):FactoryInterface;


    /**
     * @param string $alias
     * @return ElementInterface
     */
    public function getElement(string $alias):ElementInterface;
}
