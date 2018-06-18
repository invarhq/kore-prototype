<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Factory;

use Kore\Layout\Element\ElementInterface;
use \Psr\Container\ContainerInterface;

/**
 * Class FactoryAbstract
 * @package Kore\Layout\Element\Factory
 */
class Factory implements FactoryInterface
{
    protected $diContainer;
    protected $registry = [];

    /**
     * FactoryAbstract constructor.
     * @param ContainerInterface $container
     */
    final public function __construct(ContainerInterface $container)
    {
        $this->diContainer = $container;
    }

    public function registerElementType(string $alias, string $serviceId): FactoryInterface
    {
        $this->registry[$alias] = $serviceId;

        return $this;
    }


    /**
     * @param string $alias
     * @return ElementInterface
     * @throws FactoryException
     */
    public function getElement(string $alias):ElementInterface
    {
        $element = null;
        if (isset($this->registry[$alias])) {
            $element = $this->diContainer->get($this->registry[$alias]);
            if (!$element instanceof ElementInterface) {
                throw new FactoryException(
                    sprintf("The layout element must implement the %s", ElementInterface::class)
                );
            }
        } else {
            throw new FactoryException(
                sprintf("The layout element '%s' wasn't registered", $alias)
            );
        }

        return $element;
    }
}
