<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\Layout\Element\Frontend;

use DOMNode;

/**
 * Class HtmlDefault
 * @package Kore\Layout\Element\Frontend
 */
class Document extends DomAbstract
{
    /** @var DOMNode */
    protected $html;
    /** @var DOMNode */
    protected $head;
    /** @var DOMNode */
    protected $body;

    /**
     * HtmlHead constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->html = $this->createElement('html');
        $this->head = $this->createElement('head');
        $this->body = $this->createElement('body');

        $this->append($this->html);
        $this->append($this->head, $this->html);
        $this->append($this->body, $this->html);
    }

    /**
     * Initialize page title tag
     */
    protected function processTitle()
    {
        if ($this['title']) {
            $title = $this->createElement('title');
            $title->nodeValue = $this->escapeHtml($this['title']);

            $this->append($title, $this->head);
        }
    }

    /**
     * initialize javascript
     */
    protected function processMeta()
    {
        $meta = $this['meta'] ?: [];

        foreach ($meta as $metaData) {
            if (is_array($metaData) && !empty($metaData)) {
                $metaElement = $this->createElement('meta');
                foreach ($metaData as $key => $value) {
                    $metaElement->setAttribute($key, $this->escapeHtml($value));
                }
                $this->append($metaElement, $this->head);
            }
        }
    }

    /**
     * initialize javascript
     */
    protected function processScripts()
    {
        $scripts = $this['scripts'] ?: [];

        foreach ($scripts as $scriptValue) {
            $script = $this->createElement('script');
            if (!is_array($scriptValue) && strlen($scriptValue) > 0) {
                $script->setAttribute('src', $this->assetResolver->resolveAssetUri($scriptValue));
            } else {
                foreach ($scriptValue as $key => $value) {
                    if ('content' == $key) {
                        $script->nodeValue = '//<![CDATA[' . PHP_EOL . $value . PHP_EOL . '//]]>';
                    } else {
                        if ('src' == $key) {
                            $script->setAttribute($key, $this->assetResolver->resolveAssetUri($value));
                        } else {
                            $script->setAttribute($key, $this->escapeHtml($value));
                        }

                    }
                }
            }
            $this->append($script, $this->body);
        }
    }

    /**
     * Initialize css styles
     */
    protected function processStyles()
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
                        $link->setAttribute($key, $this->assetResolver->resolveAssetUri($value));
                    } else {
                        $link->setAttribute($key, $this->escapeHtml($value));
                    }
                }
                $this->append($link, $this->head);
            }
        }
    }

    /**
     * Render children elements and append them to body
     */
    protected function processChildrenHtml()
    {
        $output = '';
        if ($this->hasChildResult()) {
            foreach ($this->getChildResult() as $childOutput) {
                $output = sprintf('%s%s', $output, $childOutput);
            }
        }

        return $output;
    }

    /**
     * @return mixed|string
     */
    public function toHtml():string
    {
        $this->processTitle();
        $this->processMeta();
        $this->processStyles();
        $this->append($this->dom->createTextNode('{{document_body_content}}'), $this->body);
        $this->processScripts();

        $documentHtml = $this->dom->saveHTML();
        $childrenHtml = $this->processChildrenHtml();
        $html = str_replace('{{document_body_content}}', $childrenHtml, $documentHtml);

        return $html;
    }
}
