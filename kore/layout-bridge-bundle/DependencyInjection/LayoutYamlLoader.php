<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

namespace Kore\LayoutSymfonyBridge\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class LayoutYamlLoader extends Loader\FileLoader
{
    const FRONTEND_SERVICE_TAG = LayoutBridgeExtension::FRONTEND_SERVICE_TAG;
    const BACKEND_SERVICE_TAG = LayoutBridgeExtension::BACKEND_SERVICE_TAG;
    const FRONTEND_SERVICE_ID_PATTERN = 'kore.layout.%s.frontend';
    const BACKEND_SERVICE_ID_PATTERN = 'kore.layout.%s.backend';

    /**
     * @param mixed $resource
     * @param null $type
     * @throws \Exception
     */
    public function load($resource, $type = null)
    {
        $path = $this->locator->locate($resource);

        if ($this->container->fileExists($path)) {
            $loader = new Loader\YamlFileLoader($this->container, new FileLocator(__DIR__ . '/../Resources/config'));
            $layout = Yaml::parseFile(__DIR__ . '/../Resources/config/layout.yml');

            $diConfig = ['services' => []];

            foreach ($layout['elements'] as $name => $definition) {
                $frontendServiceId = sprintf(self::FRONTEND_SERVICE_ID_PATTERN, $name);
                $backendServiceId = sprintf(self::BACKEND_SERVICE_ID_PATTERN, $name);

                $frontendTags =  isset($definition['frontend']['tags']) ? $definition['frontend']['tags'] : [];
                $backendTags =  isset($definition['backend']['tags']) ? $definition['backend']['tags'] : [];

                $diConfig['services'][$frontendServiceId] = array_merge($definition['frontend'], [
                    'public' => true,
                    'tags' => array_merge($frontendTags, [[
                        'name' => self::FRONTEND_SERVICE_TAG,
                        'alias' => $name,
                    ]])
                ]);

                $diConfig['services'][$backendServiceId] = array_merge($definition['backend'], [
                    'public' => true,
                    'tags' => array_merge($backendTags, [[
                        'name' => self::BACKEND_SERVICE_TAG,
                        'alias' => $name,
                    ]])
                ]);
            }

            $fileName = $this->container->getParameter('kernel.cache_dir') . DIRECTORY_SEPARATOR . md5(time()) . '.yml';

            file_put_contents($fileName, Yaml::dump($diConfig));

            $loader->load($fileName);

            //unlink($fileName);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        if (!is_string($resource)) {
            return false;
        }

        if (null === $type && in_array(pathinfo($resource, PATHINFO_EXTENSION), array('yaml', 'yml'), true)) {
            return true;
        }

        return in_array($type, array('yaml', 'yml'), true);
    }
}
