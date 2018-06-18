<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge\DependencyInjection;

use Kore\Layout\Element\Frontend\ResourceAwareInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use ReflectionClass;

class LayoutHtmlElementCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     * @throws \ReflectionException
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('kore.layout.html.element.factory')) {
            return;
        }

        $factoryDefinition = $container->findDefinition('kore.layout.html.element.factory');

        $taggedServices = $container->findTaggedServiceIds('kore.layout.html.element');

        foreach ($taggedServices as $serviceId => $tags) {
            foreach ($tags as $attributes) {
                $factoryDefinition->addMethodCall('registerElementType', [
                        $attributes["alias"],
                        $serviceId,
                ]);
            }

            $definition = $container->findDefinition($serviceId);
            $reflection = new ReflectionClass($definition->getClass());
            if ($reflection->implementsInterface(ResourceAwareInterface::class)) {
                $definition->addMethodCall('setResourceResolver', [
                    'kore.layout.resource_resolver',
                ]);
            }
        }
    }
}