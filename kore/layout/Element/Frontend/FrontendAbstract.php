<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend;

use Kore\Layout\Element\DataTransport\Children;
use Kore\Layout\Element\DataTransport\ElementData;
use Kore\Layout\Element\DataTransport\PrivateData;
use Kore\Layout\Element\DataTransport\PublicData;
use Kore\Utils\FluentTrait;

/**
 * Class FrontendAbstract
 * @package Kore\Layout\Element\Frontend
 */
abstract class FrontendAbstract implements FrontendInterface
{
    use FluentTrait;

    /** @var PublicData */
    protected $data = [];
    /** @var PrivateData */
    private $privateData;
    /** @var Children */
    private $childrenResult;

    protected function getChildResult()
    {
        return $this->childrenResult;
    }

    /**
     * @return bool
     */
    protected function hasChildResult()
    {
        return !$this->childrenResult->isEmpty();
    }

    /**
     * @param string $key
     * @return mixed
     */
    protected function getPrivateData(string $key)
    {
        return $this->privateData[$key];
    }

    /**
     * @param $method
     * @param $parameters
     * @return null
     */
    public function __call($method, $parameters)
    {
        return null;
    }

    /**
     * @return mixed
     */
    abstract protected function processOutput();

    /**
     * @param ElementData $data
     * @return mixed
     */
    final public function process(ElementData $data)
    {
        $this->privateData    = $data->getPrivateData();
        $this->data           = $data->getPublicData();
        $this->childrenResult = $data->getChildren();

        return $this->processOutput();
    }
}
