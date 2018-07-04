<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout;

/**
 * Interface ResourceResolverInterface
 * @package Kore\Layout
 */
interface AssetSupplierInterface
{
    /**
     * @param string $resource
     * @param array $options
     * @return null|string
     */
    public function resolveAssetUri(string $resource, array $options = []): ?string;
}
