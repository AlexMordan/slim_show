<?php


namespace App\Controller;

use App\Model\Auth;
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
    /**
     * @var Auth
     */
    protected $auth;
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->view = $this->container->get("view");
        $this->entityManager = $this->container->get("entityManager");
        $this->auth = $this->container->get('auth');
    }

}