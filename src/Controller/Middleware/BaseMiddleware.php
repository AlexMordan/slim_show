<?php


namespace App\Controller\Middleware;


use Psr\Container\ContainerInterface;

class BaseMiddleware
{
    protected $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

}