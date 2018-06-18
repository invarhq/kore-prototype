<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\DataTransport;

/**
 * Class ElementData
 * @package Kore\Layout\Element\DataTransport
 */
class ElementData
{
    private $publicData;
    private $privateData;
    private $children;

    /**
     * ElementData constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->publicData = new PublicData();
        $this->privateData = new PrivateData(['path_in_layout' => $path]);
        $this->children = new Children();
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->getPrivateData()->get('path_in_layout');
    }

    /**
     * @return PublicData
     */
    public function getPublicData(): PublicData
    {
        return $this->publicData;
    }

    /**
     * @return PrivateData
     */
    public function getPrivateData(): PrivateData
    {
        return $this->privateData;
    }

    /**
     * @return Children
     */
    public function getChildren(): Children
    {
        return $this->children;
    }

    /**
     * @param array $map
     * @return $this
     */
    public function privateToPublic(array $map)
    {
        foreach ($map as $key) {
            $this->publicData[$key] = $this->privateData[$key];
        }

        return $this;
    }
}
