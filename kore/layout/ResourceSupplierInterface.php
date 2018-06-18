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
interface ResourceSupplierInterface
{
    /**
     * @param string $resource
     * @return null|string
     */
    public function resolveResourceUri(string $resource): ?string;
}
