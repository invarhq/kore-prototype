<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend;

/**
 * Class
 * @package Kore\Layout\Element\Frontend
 */
class FrontendDefault extends HtmlAbstract
{
    /**
     * @return mixed|string
     */
    public function toHtml():string
    {
        $output = '';
        if ($this->hasChildResult()) {
            foreach ($this->getChildResult() as $childOutput) {
                $output = sprintf('%s%s', $output, $childOutput);
            }
        }

        return $output;
    }
}
