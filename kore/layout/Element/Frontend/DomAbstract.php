<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend;

use DOMDocument;
use DOMElement;
use DOMNode;

/**
 * Class HtmlDefault
 * @package Kore\Layout\Element\Frontend
 */
abstract class DomAbstract extends HtmlAbstract
{
    /** @var DOMDocument */
    protected $dom;

    /**
     * HtmlHead constructor.
     */
    public function __construct()
    {
        $this->dom = new DOMDocument();
        $this->dom->preserveWhiteSpace = false;
        $this->dom->formatOutput = true;
    }


    /**
     * @param string $name
     * @return DOMElement
     */
    protected function createElement(string $name)
    {
        return $this->dom->createElement($name);
    }

    /**
     * @param DOMNode $element
     * @param DOMNode|null $parent
     */
    protected function append(DOMNode $element, DOMNode $parent = null)
    {
        $parent = $parent ?: $this->dom;
        $parent->appendChild($element);
        $parent->appendChild($this->dom->createTextNode("\n"));
    }
}
