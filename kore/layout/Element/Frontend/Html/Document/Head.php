<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend\Html\Document;

use DOMDocument;
use DOMElement;
use Kore\Layout\Element\Frontend\Html\HtmlAbstract;
use Kore\Layout\ResourceResolverInterface;

/**
 * Class HtmlDefault
 * @package Kore\Layout\Element\Frontend\Html
 */
class Head extends HtmlAbstract
{
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
     * @param ResourceResolverInterface $resolver
     * @return $this
     */
    public function setResourceResolver(ResourceResolverInterface $resolver)
    {
        $this->resourceResolver = $resolver;

        return $this;
    }


    /**
     * @param $name
     * @return DOMElement
     */
    protected function createElement($name)
    {
        return $this->dom->createElement($name);
    }

    /**
     * @param DOMElement $element
     */
    protected function append(DOMElement $element)
    {
        $this->dom->appendChild($element);
        $this->dom->appendChild($this->dom->createTextNode("\n"));
    }

    /**
     * Initialize page title tag
     */
    protected function initializeTitle()
    {
        if ($this['title']) {
            $title = $this->createElement('title');
            $title->nodeValue = $this->escapeHtml($this['title']);

            $this->append($title);
        }
    }

    /**
     * initialize javascript
     */
    protected function initializeMeta()
    {
        $meta = $this['meta'] ?: [];

        foreach ($meta as $metaData) {
            if (is_array($metaData) && !empty($metaData)) {
                $metaElement = $this->createElement('meta');
                foreach ($metaData as $key => $value) {
                    $metaElement->setAttribute($key, $this->escapeHtml($value));
                }
                $this->append($metaElement);
            }
        }
    }

    /**
     * initialize javascript
     */
    protected function initializeScripts()
    {
        $scripts = $this['scripts'] ?: [];

        foreach ($scripts as $scriptValue) {
            $script = $this->createElement('script');
            if (!is_array($scriptValue) && strlen($scriptValue) > 0) {
                $script->setAttribute('src', $this->resourceResolver->resolveResourceUri($scriptValue));
            } else {
                foreach ($scriptValue as $key => $value) {
                    if ('content' == $key) {
                        $script->nodeValue = '//<![CDATA[' . PHP_EOL . $value . PHP_EOL . '//]]>';
                    } else {
                        if ('src' == $key) {
                            $script->setAttribute($key, $this->resourceResolver->resolveResourceUri($value));
                        } else {
                            $script->setAttribute($key, $this->escapeHtml($value));
                        }

                    }
                }
            }
            $this->append($script);

        }
    }

    /**
     * Initialize css styles
     */
    protected function initializeStyles()
    {
        $styles = $this['styles'] ?: [];

        $default = array(
            'rel' => 'stylesheet',
            'type' => 'text/css',
            'media' => 'all'
        );

        foreach ($styles as $styleValue) {
            $link = $this->createElement('link');
            if (is_array($styleValue)) {
                $styleValue = array_merge($default, $styleValue);
            } elseif (strlen($styleValue) > 0) {
                $styleValue = array_merge($default, array(
                    'href' => $styleValue,
                ));
            }

            if (is_array($styleValue) && isset($styleValue['href'])) {
                foreach ($styleValue as $key => $value) {
                    if ('href' == $key) {
                        $link->setAttribute($key, $this->resourceResolver->resolveResourceUri($value));
                    } else {
                        $link->setAttribute($key, $this->escapeHtml($value));
                    }
                }
                $this->append($link);
            }
        }
    }

    /**
     * @return mixed|string
     */
    public function toHtml():string
    {
        $this->initializeTitle();
        $this->initializeMeta();
        $this->initializeStyles();
        $this->initializeScripts();

        return $this->dom->saveHTML();
    }
}
