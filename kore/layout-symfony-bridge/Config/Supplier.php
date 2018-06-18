<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge\Config;

use Kore\Layout\Config\SupplierInterface;
use Symfony\Component\Yaml\Parser;

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
        return $this->parser->parseFile("{$this->directory}/local.yml");
    }
}