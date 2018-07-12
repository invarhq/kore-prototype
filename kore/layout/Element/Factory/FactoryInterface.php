<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Factory;

use Kore\Layout\Element\Backend\BackendInterface;
use Kore\Layout\Element\ElementInterface;
use Kore\Layout\Element\Frontend\FrontendInterface;

/**
 * Interface FactoryInterface
 * @package Kore\Layout\Element\Factory
 */
interface FactoryInterface
{
    /**
     * @param string $alias
     * @param string $backendSvcId
     * @param string $frontendSvcId
     * @return FactoryInterface
     */
    public function registerElementService(string $alias, string $backendSvcId, string $frontendSvcId):FactoryInterface;

    /**
     * @param string $alias
     * @return BackendInterface
     */
    public function getBackendService(string $alias):BackendInterface;

    /**
     * @param string $alias
     * @return FrontendInterface
     */
    public function getFrontendService(string $alias):FrontendInterface;
}
