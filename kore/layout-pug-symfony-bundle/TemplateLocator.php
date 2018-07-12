<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutPugSymfonyBridge;

use League\Flysystem\FilesystemInterface;
use Phug\Compiler\LocatorInterface;

/**
 * Class TemplateLocatorProxy
 * @package Kore\LayoutPugSymfonyBridge
 */
class TemplateLocator implements LocatorInterface
{
    protected $filesystem;

    /**
     * TemplateLocator constructor.
     * @param FilesystemInterface $filesystem
     */
    public function __construct(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param string $path
     * @param array $locations
     * @param array $extensions
     * @return bool|string
     */
    public function locate($path, array $locations, array $extensions)
    {
        if ($this->filesystem->has($path)) {
            return $path;
        }

        return false;
    }
}
