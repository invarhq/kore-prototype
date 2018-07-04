<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout;

/**
 * Class ResourceResolver
 * @package Kore\Layout
 */
class AssetResolver implements AssetResolverInterface
{
    /**
     * @var AssetSupplierInterface[]
     */
    protected $suppliers = [];

    /**
     * @param AssetSupplierInterface $supplier
     * @return $this
     */
    public function addSupplier(AssetSupplierInterface $supplier)
    {
        $this->suppliers[] = $supplier;

        return $this;
    }

    /**
     * @param iterable $suppliers
     */
    public function setSuppliers(iterable $suppliers)
    {
        foreach ($suppliers as $supplier) {
            $this->addSupplier($supplier);
        }
    }

    /**
     * @param string $resource
     * @param array $options
     * @return null|string
     */
    public function resolveAssetUri(string $resource, array $options = []): ?string
    {
        foreach ($this->suppliers as $supplier) {
            if ($resource = $supplier->resolveAssetUri($resource, $options)) {
                return $resource;
            }
        }

        return $resource;
    }
}
