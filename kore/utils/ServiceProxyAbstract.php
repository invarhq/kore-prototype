<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Utils;

/**
 * Class ServiceFacadeAbstract
 * @package Kore\Utils
 */
abstract class ServiceProxyAbstract
{
    protected static $serviceRegistry = [];

    /**
     * @param $service
     */
    public static function setService($service)
    {
        self::$serviceRegistry[static::class] = $service;
    }

    /**
     * @return mixed
     */
    protected static function getService()
    {
        return self::$serviceRegistry[static::class];
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        return call_user_func_array([self::getService(), $name], $arguments);
    }

    /**
     * @param mixed ...$arguments
     * @return mixed
     */
    public function __invoke(...$arguments)
    {
        return call_user_func_array(self::getService(), $arguments);
    }
}
