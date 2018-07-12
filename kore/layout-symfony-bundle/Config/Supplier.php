<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge\Config;

use Kore\Layout\Config\SupplierInterface;
use Symfony\Component\Yaml\Parser;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

/**
 * Class Provider
 * @package Kore\LayoutSymfonyBridge\Config
 */
class Supplier implements SupplierInterface
{
    protected $parser;
    protected $directory;

    /**
     * Supplier constructor.
     * @param string $layoutDirectory
     */
    public function __construct($layoutDirectory)
    {
        $this->parser = new Parser();
        $this->directory = $layoutDirectory;
    }

    /**
     * @return array
     */
    public function getConfig():array
    {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->directory));
        $basePathLen = strlen($this->directory);

        $config = [];

        /** @var \SplFileInfo $file */
        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }
            $handle = ltrim(substr(substr($file->getPathname(), 0, strlen($file->getPathname())-4), $basePathLen), '/');
            $handle = str_replace(DIRECTORY_SEPARATOR, '_', $handle);
            $config[$handle] = $this->parser->parseFile($file->getPathname());
        }

        return $config;
    }
}
