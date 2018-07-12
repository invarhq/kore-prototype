<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge\DependencyInjection;

use Kore\Layout\Element\Frontend\FrontendAssetAwareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ReflectionClass;

class LayoutElementCompilerPass implements CompilerPassInterface
{
    const FACTORY_SERVICE_ID =  'kore.layout.element.factory';

    /**
     * @param ContainerBuilder $container
     * @throws \ReflectionException
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(self::FACTORY_SERVICE_ID)) {
            return;
        }

        $factoryDefinition = $container->findDefinition(self::FACTORY_SERVICE_ID);
        $frontendServices  = $container->findTaggedServiceIds(LayoutBridgeExtension::FRONTEND_SERVICE_TAG);
        $backendServices   = $container->findTaggedServiceIds(LayoutBridgeExtension::BACKEND_SERVICE_TAG);
        $elements          = [];

        foreach ($frontendServices as $serviceId => $tags) {
            foreach ($tags as $attributes) {
                $elements[$attributes["alias"]]['frontend'] = $serviceId;
            }
        }

        foreach ($backendServices as $serviceId => $tags) {
            foreach ($tags as $attributes) {
                $elements[$attributes["alias"]]['backend'] = $serviceId;
            }
        }

        foreach ($elements as $alias => $service) {
            $factoryDefinition->addMethodCall('registerElementService', [
                $alias,
                $service['backend'],
                $service['frontend'],
            ]);
        }
    }
}
