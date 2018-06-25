<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Utils;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

/**
 * Class LocalFilesystem
 * @package Kore\Utils
 * @method Local getAdapter
 */
class LocalFilesystem extends Filesystem
{
    /**
     * LocalFilesystem constructor.
     * @param Local $adapter
     * @param null $config
     */
    public function __construct(Local $adapter, $config = null)
    {
        parent::__construct($adapter, $config);
    }

    /**
     * @return null|string
     */
    public function getPathPrefix():string
    {
        return $this->getAdapter()->getPathPrefix();
    }

    /**
     * @param string $path
     * @return string
     */
    public function applyPathPrefix(string $path):string
    {
        return $this->getAdapter()->applyPathPrefix($path);
    }

    /**
     * @param string $path
     * @return string
     */
    public function removePathPrefix(string $path):string
    {
        return $this->getAdapter()->removePathPrefix($path);
    }
}
