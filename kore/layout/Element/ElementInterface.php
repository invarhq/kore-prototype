<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element;

use Kore\Layout\Element\Backend\BackendInterface;
use Kore\Layout\Element\Frontend\FrontendInterface;

/**
 * Class FrontendAbstract
 * @package Kore\Layout\Element\Frontend
 */
interface ElementInterface
{
    /**
     * @return BackendInterface
     */
    public function getBackend():BackendInterface;

    /**
     * @return FrontendInterface
     */
    public function getFrontend():FrontendInterface;
}