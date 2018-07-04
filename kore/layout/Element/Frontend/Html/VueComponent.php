<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend\Html;

use DOMDocument;
use DOMElement;
use DOMNode;
use Kore\Layout\AssetResolverInterface;

/**
 * Class HtmlDefault
 * @package Kore\Layout\Element\Frontend\Html
 */
class VueComponent extends DomAbstract
{
    /**
     * @return mixed|string
     */
    public function toHtml():string
    {
        $basename = basename($this->getPrivateData('path_in_layout'));
        $wrapper = $this->createElement('div');
        $wrapper->setAttribute('class', "v-{$basename}");
        $element = $this->createElement($basename);
        $wrapper->appendChild($element);
        $this->append($wrapper);

        return $this->dom->saveHTML();
    }
}
