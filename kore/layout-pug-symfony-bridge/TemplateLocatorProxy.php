<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutPugSymfonyBridge;

use Kore\Utils\ServiceProxyAbstract;
use Phug\Compiler\LocatorInterface;

/**
 * Class TemplateLocatorProxy
 * @package Kore\LayoutPugSymfonyBridge
 */
class TemplateLocatorProxy extends ServiceProxyAbstract implements LocatorInterface
{
    /**
     * @param string $path
     * @param array $locations
     * @param array $extensions
     * @return mixed|string
     */
    public function locate($path, array $locations, array $extensions)
    {
        return call_user_func_array([self::getService(), 'locate'], [
            $path, $locations, $extensions
        ]);
    }
}
