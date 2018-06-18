<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Utils;

/**
 * Class Fluent
 * @package Kore\Utils
 */
class Fluent implements FluentInterface
{
    use FluentTrait;

    /**
     * Fluent constructor.
     * @param null $data
     */
    public function __construct($data = null)
    {
        switch (true) {
            case is_array($data):
                $this->setData($data);
                break;
            case $data instanceof Arrayable:
                $this->setData($data->toArray());
                break;
        }
    }
}
