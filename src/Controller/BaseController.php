<?php


namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Slim\Views\PhpRenderer;

class BaseController
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var PhpRenderer
     */
    protected $view;
    /**
     * @var EntityManager
     */
    protected $entityManager;
    // constructor receives container instance
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->view = $this->container->get("view");
        $this->entityManager = $this->container->get("entityManager");
    }

}