<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend\Html;

use Kore\Layout\Element\Frontend\FrontendAbstract;
use Kore\Layout\Element\Frontend\ResourceAwareInterface;
use Kore\Layout\ResourceResolverInterface;
use Kore\Utils\Htmlable;

/**
 * Class HtmlAbstract
 * @package Kore\Layout\Element\Frontend\Html
 */
abstract class HtmlAbstract extends FrontendAbstract implements Htmlable, ResourceAwareInterface
{
    /** @var ResourceResolverInterface */
    protected $resourceResolver;

    /**
     * @param ResourceResolverInterface $resolver
     * @return $this
     */
    public function setResourceResolver(ResourceResolverInterface $resolver)
    {
        $this->resourceResolver = $resolver;

        return $this;
    }
//
//
//    /**
//     * @param $path
//     * @param array $params
//     * @return string
//     */
//    public function getUrl($path, array $params = [])
//    {
//        return $this->frontend->getUrl($path, $params);
//    }

    /**
     * @param $resourcePath
     * @return string
     */
    public function getResourceUrl($resourcePath)
    {
        return $this->resourceResolver->resolveResourceUri($resourcePath);
    }

    /**
     * @param string $value
     * @return string
     */
    public function escapeHtml($value)
    {
        return htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false);
    }

    /**
     * @return string
     */
    public function getCsrfToken()
    {
        throw new Exception('Method not implemented');
    }

    /**
     * @return mixed|string
     */
    protected function processOutput()
    {
        return $this->toHtml();
    }

    /**
     * @param string $key
     * @param null $default
     * @return string
     */
    public function get($key, $default = null)
    {
        if ($this->getChildResult()->has($key)) {
            return $this->getChildResult()->get($key);
        }

        return parent::get($key, $default);
    }
}
