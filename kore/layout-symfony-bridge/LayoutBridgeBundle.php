<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class LayoutBridgeBundle
 * @package Kore\LayoutSymfonyBridge
 */
class LayoutBridgeBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new DependencyInjection\LayoutBridgeBundleExtension();
    }

    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DependencyInjection\LayoutHtmlElementCompilerPass());
        $container->addCompilerPass(new DependencyInjection\LayoutJsonElementCompilerPass());
    }
}