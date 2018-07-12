<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutPugSymfonyBridge;

use League\Flysystem\FilesystemInterface;

/**
 * Class TemplateLocatorProxy
 * @package Kore\LayoutPugSymfonyBridge
 */
class TemplateLoader
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
     * @param mixed ...$arguments
     * @return false|string
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function __invoke(...$arguments)
    {
        return $this->filesystem->read($arguments[0]);
    }
}
