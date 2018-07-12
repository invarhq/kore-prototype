<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend;

/**
 * Class HtmlText
 * @package Kore\Layout\Element\Frontend
 */
class Text extends HtmlAbstract
{
    /**
     * @return string
     */
    public function toHtml():string
    {
        return (string) $this['text'];
    }
}
