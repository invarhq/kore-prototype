<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutTwigSymfonyBridge;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class LayoutBridgeBundle
 * @package Kore\LayoutSymfonyBridge
 */
class LayoutTwigSymfonyBridge extends Bundle
{
    public function getContainerExtension()
    {
        return new DependencyInjection\LayoutTwigSymfonyBridgeExtension();
    }
}
