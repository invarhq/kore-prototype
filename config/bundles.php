<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Symfony\Bundle\WebServerBundle\WebServerBundle::class => ['dev' => true],
    Kore\LayoutSymfonyBridge\LayoutBridgeBundle::class => ['all' => true],
    Kore\LayoutPugSymfonyBridge\LayoutPugSymfonyBridge::class => ['all' => true],
    Kore\LayoutTwigSymfonyBridge\LayoutTwigSymfonyBridge::class => ['all' => true],
    Kore\LayoutVueBundle\LayoutVueBundle::class => ['all' => true],
    Wasinger\BundleAssetProviderBundle\WasingerBundleAssetProviderBundle::class => ['all' => true],
];
