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
use \Psr\Container\ContainerInterface;

/**
 * Class FactoryAbstract
 * @package Kore\Layout\Element\Factory
 */
class Factory implements FactoryInterface
{
    protected $diContainer;
    protected $frontendRegistry = [];
    protected $backendRegistry = [];

    /**
     * FactoryAbstract constructor.
     * @param ContainerInterface $container
     */
    final public function __construct(ContainerInterface $container)
    {
        $this->diContainer = $container;
    }

    /**
     * @param string $alias
     * @param string $backendSvcId
     * @param string $frontendSvcId
     * @return FactoryInterface
     */
    public function registerElementService(string $alias, string $backendSvcId, string $frontendSvcId): FactoryInterface
    {
        $this->backendRegistry[$alias] = $backendSvcId;
        $this->frontendRegistry[$alias] = $frontendSvcId;

        return $this;
    }

    /**
     * @param string $alias
     * @return FrontendInterface
     * @throws FactoryException
     */
    public function getFrontendService(string $alias): FrontendInterface
    {
        $service = null;
        if (isset($this->frontendRegistry[$alias])) {
            $service = $this->diContainer->get($this->frontendRegistry[$alias]);
            if (!$service instanceof FrontendInterface) {
                throw new FactoryException(
                    sprintf("The frontend service must implement the %s", FrontendInterface::class)
                );
            }
        } else {
            throw new FactoryException(
                sprintf("The frontend service for '%s' wasn't registered", $alias)
            );
        }

        return $service;
    }

    /**
     * @param string $alias
     * @return BackendInterface
     * @throws FactoryException
     */
    public function getBackendService(string $alias): BackendInterface
    {
        $service = null;
        if (isset($this->backendRegistry[$alias])) {
            $service = $this->diContainer->get($this->backendRegistry[$alias]);
            if (!$service instanceof BackendInterface) {
                throw new FactoryException(
                    sprintf("The backend service must implement the %s", BackendInterface::class)
                );
            }
        } else {
            throw new FactoryException(
                sprintf("The backend service for '%s' wasn't registered", $alias)
            );
        }

        return $service;
    }
}
