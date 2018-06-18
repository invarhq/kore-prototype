<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend\Json;

use Kore\Layout\Element\Frontend\FrontendAbstract;

/**
 * Class JsonAbstract
 * @package Kore\Layout\Element\Frontend\Json
 */
abstract class JsonAbstract extends FrontendAbstract implements JsonInterface
{
    /**
     * @return array
     */
    protected function processOutput()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function toArray():array
    {
        return $this->prepareArray(array_merge($this->data->toArray(), $this->getChildResult()));
    }
}
