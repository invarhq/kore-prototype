<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge\Element;

use League\Flysystem\Adapter;
use League\Flysystem\Filesystem;

/**
 * Class TemplateFilesystemFactory
 * @package Kore\LayoutSymfonyBridge\Element
 */
class TemplateFilesystemFactory
{
    protected $baseDir;

    /**
     * TemplateFilesystemFactory constructor.
     * @param string $templateDir
     */
    public function __construct(string $templateDir)
    {
        $this->baseDir = $templateDir;
    }

    /**
     * @return Filesystem
     */
    public function createFilesystem()
    {
        $adapter = new Adapter\Local($this->baseDir);

        return new Filesystem($adapter);
    }
}
