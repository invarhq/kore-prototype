<?php
/**
 * Copyright (C) 2018 Sergey Cherepanov - All Rights Reserved
 * You may use, distribute and modify this code under the
 * terms of the MIT license.
 */

// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as ControllerAbstract;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Psr\Container\ContainerInterface;

/**
 * Class DefaultController
 * @package App\Controller
 * @method ContainerInterface getContainer()
 */
class ContactsController extends ControllerAbstract
{
    public function index()
    {
        $layoutConfig = $this->get('kore.layout.config');
        $layoutConfig->load(['contacts']);

        $processor = $this->get('kore.layout.json.processor');

        return new JsonResponse($processor->process($layoutConfig));
    }
}
