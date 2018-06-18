<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class LayoutJsonElementCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('kore.layout.json.element.factory')) {
            return;
        }

        $definition = $container->findDefinition('kore.layout.json.element.factory');

        $taggedServices = $container->findTaggedServiceIds('kore.layout.json.element');

        foreach ($taggedServices as $serviceId => $tags) {
            foreach ($tags as $attributes) {
                $definition->addMethodCall('registerElementType', [
                        $attributes["alias"],
                        $serviceId,
                ]);
            }
        }
    }
}