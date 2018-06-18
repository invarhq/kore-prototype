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
class ResourceResolver implements ResourceResolverInterface
{
    /**
     * @var ResourceSupplierInterface[]
     */
    protected $suppliers = [];

    /**
     * @param ResourceSupplierInterface $supplier
     * @return $this
     */
    public function addSupplier(ResourceSupplierInterface $supplier)
    {
        $this->suppliers[] = $supplier;

        return $this;
    }

    /**
     * @param string $resource
     * @return string
     */
    public function resolveResourceUri(string $resource): ?string
    {
        foreach ($this->suppliers as $supplier) {
            if ($resource = $supplier->resolveResourceUri($resource)) {
                return $resource;
            }
        }

        return null;
    }
}
