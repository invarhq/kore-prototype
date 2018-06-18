<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Backend;

use Kore\Layout\Element\Frontend\FrontendInterface;

/**
 * Class BackendAbstract
 * @package Kore\Layout\Element\Backend
 */
abstract class BackendAbstract implements BackendInterface
{
    /** @var  FrontendInterface */
    protected $frontend;

    /**
     * @param FrontendInterface $output
     */
    final public function setFrontend(FrontendInterface $output)
    {
        $this->frontend = $output;
    }

    /**
     * @return null
     */
    public function __invoke()
    {
        return null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }
}
