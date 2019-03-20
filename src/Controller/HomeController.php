<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller as ControllerAbstract;
use Symfony\Component\HttpFoundation\Response;
use Psr\Container\ContainerInterface;

/**
 * Class DefaultController
 * @package App\Controller
 * @method ContainerInterface getContainer()
 */
class HomeController extends ControllerAbstract
{
    public function index()
    {
        $layoutConfig = $this->get('kore.layout.config');
        $layoutConfig->load('home');

        $processor = $this->get('kore.layout.html.processor');

        return new Response($processor->process($layoutConfig));
    }
}