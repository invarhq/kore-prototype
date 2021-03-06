<?php

/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 * Class LayoutBridgeBundleExtension
 * @package Kore\LayoutSymfonyBridge\DependencyInjection
 */
class LayoutBridgeExtension extends Extension
{
    const FRONTEND_SERVICE_TAG = 'kore.layout.frontend';
    const BACKEND_SERVICE_TAG = 'kore.layout.backend';

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $layoutLoader = new LayoutYamlLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $layoutLoader->load(__DIR__ . '/../Resources/config/layout.yml');
    }
}
