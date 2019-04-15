<?php


namespace App\Controller;


use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class PageController extends BaseController
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function home(Request $request, Response $response)
    {
        return $this->view->render($response,'pages/home.twig');
    }
    public function about(Request $request, Response $response)
    {
        return $this->view->render($response,'pages/about.twig');

    }

}