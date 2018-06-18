<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend;

use Kore\Layout\ResourceResolverInterface;

/**
 * Interface ResourceAwareInterface
 * @package Kore\Layout\Element\Frontend
 */
interface ResourceAwareInterface
{
    /**
     * @param ResourceResolverInterface $resolver
     * @return mixed
     */
    public function setResourceResolver(ResourceResolverInterface $resolver);
}
