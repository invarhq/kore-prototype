<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Processor;

use Kore\Layout\Element\Backend\BackendInterface;
use Kore\Layout\Element\DataTransport\ElementData;
use Kore\Layout\Element\Frontend\FrontendInterface;
use Kore\Utils\Debug\DebugInterface;
use Kore\Layout\ConfigInterface;
use Kore\Layout\Element\Factory\FactoryInterface;

/**
 * Class ProcessorAbstract
 * @package Kore\Layout\Processor
 */
abstract class ProcessorAbstract implements ProcessorInterface
{
    const DEFAULT_ROOT_ELEMENT_NAME = 'root';

    /** @var  FactoryInterface */
    protected $factory;
    /** @var array */
    protected $dataRegistry = [];
    /** @var  DebugInterface */
    protected $debug;

    /**
     * ProcessorAbstract constructor.
     * @param FactoryInterface $factory
     * @param DebugInterface $debug
     */
    public function __construct(
        FactoryInterface $factory,
        DebugInterface $debug
    ) {
        $this->factory = $factory;
        $this->debug = $debug;
    }

    /**
     * @param array $elementConfig
     * @return array
     */
    protected function extractElementAttributes(array &$elementConfig):array
    {
        $attributes = [];
        foreach ($elementConfig as $key => $value) {
            if (0 === strpos($key, '_')) {
                $k              = substr($key, 1);
                $attributes[$k] = $value;
                unset($elementConfig[$key]);
            }
        }

        return $attributes;
    }

    /**
     * @param $name
     * @return bool
     */
    protected function isElementNode($name)
    {
        return 0 < preg_match('/^[^_]\w+$/ui', $name);
    }

    /**
     * @param array $array
     * @param array $addArray
     * @param int $offset
     * @return array
     */
    protected function addToArray(array $array, array $addArray, $offset)
    {
        return array_slice($array, 0, $offset, true) +
            $addArray + array_slice($array, $offset, null, true);
    }

    /**
     * @param array $elements
     * @return array
     */
    protected function sortElementsRecursive(array $elements)
    {
        $offset = 0;
        while (false !== ($data = current($elements))) {
            if (!is_array($data)) {
                continue;
            }
            $key   = key($elements);
            $reset = false;
            if (isset($data['_before']) && ($target = $data['_before'])) {
                unset($data['_before'], $data['_after']);
                if ('*' == $target) {
                    unset($elements[$key]);
                    $elements = [$key => $data] + $elements;
                    $reset    = true;
                } elseif (isset($elements[$target])) {
                    unset($elements[$key]);
                    if (false !== ($offset = array_search($target, array_keys($elements)))) {
                        $elements = $this->addToArray($elements, [$key => $data], $offset);
                    }
                    $reset = true;
                }
            } elseif (isset($data['_after']) && ($target = $data['_after'])) {
                unset($data['_before'], $data['_after']);
                if ('*' == $target) {
                    unset($elements[$key]);
                    $elements = $elements + [$key => $data];
                    $reset    = true;
                } elseif (isset($elements[$target])) {
                    unset($elements[$key]);
                    if (false !== ($offset = array_search($target, array_keys($elements)))) {
                        $elements = $this->addToArray($elements, [$key => $data], $offset + 1);
                    }
                    $reset = true;
                }
            }

            if ($reset) {
                reset($elements);
                $offset = 0;
            } else {
                next($elements);
                $offset++;
            }
        }

        return $elements;
    }

    /**
     * @param ElementData $data
     * @return BackendInterface
     */
    protected function getBackend(ElementData $data): BackendInterface
    {
        return $this->factory->getBackendService($data->getPrivateData()['type'] ?: 'default');
    }

    /**
     * @param ElementData $data
     * @return FrontendInterface
     */
    protected function getFrontend(ElementData $data): FrontendInterface
    {
        return $this->factory->getFrontendService($data->getPrivateData()['type'] ?: 'default');
    }

    /**
     * @param $elementPath
     * @return ElementData
     */
    protected function getElementData(string $elementPath)
    {
        if (!isset($this->dataRegistry[$elementPath])) {
            $this->dataRegistry[$elementPath] = new ElementData($elementPath);
        }

        return $this->dataRegistry[$elementPath];
    }

    /**
     * @param array $elements
     * @param string $path
     * @return $this
     */
    protected function prepareBackend(array $elements, string $path = '')
    {
        foreach ($elements as $elementName => $elementsConfig) {
            $elementPath = "{$path}/{$elementName}";
            $privateData  = [
                'name_in_layout' => $elementName,
                'path_in_layout' => $elementPath,
            ];
            if (is_array($elementsConfig)) {
                if (!empty($elementsConfig)) {
                    $privateData += $this->extractElementAttributes($elementsConfig);
                    $this->prepareBackend($elementsConfig, $elementPath);
                }
            }

            $elementData = $this->getElementData($elementPath);
            $elementData->getPrivateData()->setData($privateData);
            $backend = $this->getBackend($elementData);
            $backend->prepare($elementData);
        }

        return $this;
    }

    /**
     * @param array $elements
     * @param string $path
     * @return $this
     */
    protected function processBackend(array $elements, string $path = '')
    {
        foreach ($elements as $elementName => $elementsConfig) {
            $elementPath = "{$path}/{$elementName}";
            if (is_array($elementsConfig)) {
                if (!empty($elementsConfig)) {
                    $this->processBackend($elementsConfig, $elementPath);
                }
            }
            $elementData = $this->getElementData($elementPath);
            $backend = $this->getBackend($elementData);
            $backend->process($elementData);
        }

        return $this;
    }

    /**
     * @param FrontendInterface $frontend
     * @param ElementData $elementData
     * @return mixed
     */
    abstract protected function processFrontendOutput(FrontendInterface $frontend, ElementData $elementData);

    /**
     * @param array $elements
     * @param string $path
     * @return array
     */
    protected function processFrontend(array $elements, string $path = ''):array
    {
        $result   = [];
        foreach ($elements as $elementName => $elementsConfig) {
            $elementPath = "{$path}/{$elementName}";
            $elementData = $this->getElementData($elementPath);
            if (is_array($elementsConfig) && $elementsConfig) {
                $elementData->getChildren()->concat($this->processFrontend($elementsConfig, $elementPath));
            }

            $result[$elementName] = $this->processFrontendOutput($this->getFrontend($elementData), $elementData);
        }

        return $result;
    }


    /**
     * @param ConfigInterface $layoutConfig
     * @return mixed
     * @throws ProcessorException
     */
    public function process(ConfigInterface $layoutConfig)
    {
        $this->debug->startDebugMeasure('layout_render', 'Time for rendering layout');
        $result = [];
        $config = $layoutConfig->toArray();
        if (!empty($config)) {
            $elementsConfig = [
                self::DEFAULT_ROOT_ELEMENT_NAME => $config
            ];

            $this->sortElementsRecursive($elementsConfig);
            $this->prepareBackend($elementsConfig);
            $this->processBackend($elementsConfig);
            $result = $this->processFrontend($elementsConfig);

            $this->debug->stopDebugMeasure('layout_render');
        }

        return isset($result[self::DEFAULT_ROOT_ELEMENT_NAME]) ? $result[self::DEFAULT_ROOT_ELEMENT_NAME] : null;
    }
}
