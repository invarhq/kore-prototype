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
class Element implements ElementInterface
{
    protected $backend;
    protected $frontend;

    /**
     * Element constructor.
     * @param BackendInterface $backend
     * @param FrontendInterface $frontend
     */
    public function __construct(BackendInterface $backend, FrontendInterface $frontend)
    {
        $this->backend = $backend;
        $this->frontend = $frontend;
    }

    /**
     * @return BackendInterface
     */
    public function getBackend(): BackendInterface
    {
        return $this->backend;
    }

    /**
     * @return FrontendInterface
     */
    public function getFrontend(): FrontendInterface
    {
        return $this->frontend;
    }
}