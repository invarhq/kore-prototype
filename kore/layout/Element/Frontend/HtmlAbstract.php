<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend;

use Kore\Layout\AssetResolverInterface;

/**
 * Class HtmlAbstract
 * @package Kore\Layout\Element\Frontend
 */
abstract class HtmlAbstract extends FrontendAbstract implements FrontendAssetAwareInterface
{
    /** @var AssetResolverInterface */
    protected $assetResolver;

    /**
     * @param AssetResolverInterface $resolver
     * @return $this
     */
    public function setAssetResolver(AssetResolverInterface $resolver)
    {
        $this->assetResolver = $resolver;

        return $this;
    }

    /**
     * @param $resourcePath
     * @return string
     */
    public function getAssetUrl($resourcePath)
    {
        return $this->assetResolver->resolveAssetUri($resourcePath);
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
     * @throws \Exception
     */
    public function getCsrfToken()
    {
        throw new \Exception('Method not implemented');
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
