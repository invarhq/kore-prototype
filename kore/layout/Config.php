<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout;

use Carbon\Carbon;
use Kore\Layout\Config\ConfigException;
use Kore\Layout\Config\SupplierInterface;
use Kore\Utils\Debug\DebugInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * Class Config
 * @package Kore\Layout
 */
class Config implements ConfigInterface
{
    const ACTION_EXTEND  = '%extend';
    const ACTION_REWRITE = '%rewrite';
    const ACTION_REMOVE  = '%remove';

    protected $actions = [self::ACTION_REWRITE, self::ACTION_REMOVE, self::ACTION_EXTEND];

    protected $systemNodes = [];

    protected $suppliers = [];

    protected $configPath = [];
    protected $scopeData  = [];
    protected $data       = [];
    protected $handles    = [];

    protected $cacheEnabled = true;

    protected $cache;
    protected $cachePrefix = 'layout::';
    protected $debug;
    protected $cacheExpiresAt;

    /**
     * Config constructor.

     * @param CacheInterface $cache
     * @param DebugInterface $debug
     */
    public function __construct(CacheInterface $cache, DebugInterface $debug)
    {
        $this->cache          = $cache;
        $this->debug          = $debug;
        $this->cacheExpiresAt = Carbon::now()->addMinutes(60);
    }

    /**
     * @param iterable|array|SupplierInterface[] $suppliers
     * @return $this
     * @throws ConfigException
     */
    public function setSuppliers(iterable $suppliers)
    {
        $this->suppliers = [];
        foreach ($suppliers as $supplier) {
            if ($supplier instanceof SupplierInterface) {
                $this->suppliers[] = $supplier;
            } else {
                throw new ConfigException(
                    sprintf(
                        "The supplier class '%s' must implement 'SupplierInterface' interface",
                        get_class($supplier)
                    )
                );
            }
        }

        return $this;
    }

    /**
     * @param $minutes
     * @return $this
     */
    public function setCacheExpiresAt($minutes)
    {
        $this->cacheExpiresAt = Carbon::now()->addMinutes($minutes);

        return $this;
    }

    /**
     * @param bool $flag
     * @return $this
     */
    public function setCacheEnabled($flag = true)
    {
        $this->cacheEnabled = $flag;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function setCache($key, $value)
    {
        if ($this->cacheEnabled) {
            $this->cache->set($this->cachePrefix . $key, $value, $this->cacheExpiresAt);
        }

        return $this;
    }

    /**
     * @param $key
     * @return bool|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function getCache($key)
    {
        if ($this->cacheEnabled) {
            return $this->cache->get($this->cachePrefix . $key, false);
        }

        return false;
    }

    /**
     * @param string $key
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function hasCache($key)
    {
        if ($this->cacheEnabled) {
            return $this->cache->has($this->cachePrefix . $key);
        }

        return false;
    }

    /**
     * @param array $target
     * @param array $data
     * @return array
     */
    protected function arrayMerge(array $target, array $data)
    {
        foreach ($data as $key => $value) {
            if (isset($target[$key])) {
                if (in_array($key, $this->actions)) {
                    $target[$key] = array_merge((array)$target[$key], (array)$value);
                } elseif (is_array($target[$key]) || is_array($value)) {
                    $target[$key] = $this->arrayMerge((array)$target[$key], (array)$value);
                } else {
                    $target[$key] = $value;
                }
            } else {
                $target[$key] = $value;
            }
        }

        return $target;
    }

    /**
     * @param $scopeData
     * @return $this
     */
    protected function applyRemoves(&$scopeData)
    {
        foreach ($scopeData as $key => $value) {
            if (self::ACTION_REMOVE == $key) {
                foreach ((array)$value as $path) {
                    $path   = explode('/', $path);
                    $config = &$scopeData;
                    while ($name = array_shift($path)) {
                        if (empty($path)) {
                            unset($config[$name]);
                            continue 2;
                        } else {
                            if (isset($config[$name])) {
                                $config = &$config[$name];
                            } else {
                                continue 2;
                            }
                        }
                    }
                }
                unset($scopeData[$key]);
            }
        }

        return $this;
    }

    /**
     * @param $scopeData
     * @return $this
     */
    protected function applyExtends(&$scopeData)
    {
        foreach ($scopeData as $key => $value) {
            if (self::ACTION_EXTEND == $key) {
                foreach ((array)$value as $path => $data) {
                    $path   = explode('/', $path);
                    $config = &$scopeData;
                    while ($name = array_shift($path)) {
                        if (empty($config[$name])) {
                            break;
                        }
                        if (empty($path)) {
                            $config[$name] = $this->arrayMerge($config[$name], $data);
                            break;
                        } else {
                            if (isset($config[$name])) {
                                $config = &$config[$name];
                            } else {
                                break;
                            }
                        }
                    }
                }
                unset($scopeData[$key]);
            }
        }

        return $this;
    }

    /**
     * @param $scopeData
     * @return $this
     */
    protected function applyRewrites(&$scopeData)
    {
        foreach ($scopeData as $key => $value) {
            if (self::ACTION_REWRITE == $key) {
                foreach ((array)$value as $path => $data) {
                    $path   = explode('/', $path);
                    $config = &$scopeData;
                    while ($name = array_shift($path)) {
                        if (empty($config[$name])) {
                            break;
                        }
                        if (empty($path)) {
                            $config[$name] = $data;
                            break;
                        } else {
                            if (isset($config[$name])) {
                                $config = &$config[$name];
                            } else {
                                break;
                            }
                        }
                    }
                }
                unset($scopeData[$key]);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getHandles()
    {
        return $this->handles;
    }

    /**
     * @param string $handle
     * @return $this
     */
    public function addHandle($handle)
    {
        $this->handles[] = $handle;

        return $this;
    }

    /**
     * @param array $handles
     * @return $this
     */
    public function setHandles(array $handles)
    {
        $this->handles = $handles;

        return $this;
    }

    /**
     * @return array
     */
    private function getConfig()
    {
        $config = [];
        foreach ($this->suppliers as $provider) {
            $config = $this->arrayMerge($config, $provider->getConfig());
        }

        return $config;
    }

    /**
     * @param array $handles
     * @param bool $includeDefaultHandle
     * @return $this|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function load($handles = [], $includeDefaultHandle = true)
    {
        $this->debug->startDebugMeasure('layout_config_load', 'Loading Layout Configuration');

        if ($handles && !is_array($handles)) {
            $handles = [$handles];
        }
        if ($includeDefaultHandle) {
            $handles[] = 'default';
        }
        $handles = array_unique($handles);

        sort($handles);

        $cacheKey = 'config::' . implode('|', $handles);

        if ($this->hasCache($cacheKey)) {
            $scopeData = $this->getCache($cacheKey);
        } else {
            $scopeData = null;
            if ($this->hasCache('config')) {
                $config = $this->getCache('config');
            } else {
                $config = $this->getConfig();
                $this->setCache('config', $config);
            }

            foreach ($config as $handle => $handleConfig) {
                if (in_array($handle, $handles)) {
                    if (empty($scopeData)) {
                        $scopeData = $handleConfig;
                    } else {
                        $scopeData = $this->arrayMerge($scopeData, $handleConfig);
                    }
                }
            }

            if (!is_array($scopeData)) {
                $scopeData = [];
            }

            $this->applyRewrites($scopeData);
            $this->applyExtends($scopeData);
            $this->applyRemoves($scopeData);

            $scopeData = array_shift($scopeData);


            $this->setCache($cacheKey, $scopeData);
        }

        $this->data = $scopeData;

        $this->debug->stopDebugMeasure('layout_config_load');

        return $this;
    }

    /**
     * @param string $target
     * @return $this|mixed
     */
    public function setTarget($target)
    {
        if ($target) {
            $path = explode('/', $target);
            if (!empty($path)) {
                $data = $this->scopeData;
                while ($elementName = array_shift($path)) {
                    if (isset($data[$elementName])) {
                        $data = $data[$elementName];
                    } else {
                        $data = null;
                        break;
                    }

                }
                $this->data = $data;
            }
        }

        return $this;
    }
}
