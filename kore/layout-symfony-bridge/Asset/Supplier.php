<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge\Asset;

use Kore\Layout\AssetSupplierInterface;
use Symfony\Component\Asset\Package;
use Symfony\Component\Asset\VersionStrategy\JsonManifestVersionStrategy;

/**
 * Class Supplier
 * @package Kore\LayoutPugSymfonyBridge\Asset
 */
class Supplier implements AssetSupplierInterface
{
    protected $package;

    /**
     * Supplier constructor.
     * @param array $assetsConfig
     */
    public function __construct(array $assetsConfig)
    {
        $this->package = new Package(
            new JsonManifestVersionStrategy($assetsConfig['json_manifest_path'])
        );
    }

    /**
     * @param string $resource
     * @param array $options
     * @return null|string
     */
    public function resolveAssetUri(string $resource, array $options = []): ?string
    {
        return (string) $this->package->getUrl($resource);
    }
}
