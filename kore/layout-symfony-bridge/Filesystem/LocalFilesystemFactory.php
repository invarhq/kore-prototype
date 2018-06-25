<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge\Filesystem;

use Kore\Utils\LocalFilesystem;
use League\Flysystem\Adapter;
use League\Flysystem\Filesystem;

/**
 * Class TemplateFilesystemFactory
 * @package Kore\LayoutSymfonyBridge\Element
 */
class LocalFilesystemFactory
{
    protected $baseDir;

    /**
     * TemplateFilesystemFactory constructor.
     * @param string $baseDir
     */
    public function __construct(string $baseDir)
    {
        $this->baseDir = $baseDir;
    }

    /**
     * @return Filesystem
     */
    public function createFilesystem()
    {
        $adapter = new Adapter\Local($this->baseDir);

        return new LocalFilesystem($adapter);
    }
}
