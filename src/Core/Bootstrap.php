<?php

namespace App\Core;

use App\Controller\AuthenticationController;
use App\Controller\Middleware\AuthMiddleware;
use App\Controller\Middleware\GuestMiddleware;
use App\Controller\PageController;
use App\Controller\UserController;
use App\Model\Auth;
use Dotenv\Dotenv;
use Slim\App;
use Slim\Container;
use Twig\Extension\DebugExtension;

class Bootstrap
{
    /**
     * @var Container
     */
    private $container;
    /**
     * @var App
     */
    private $app;

    public function __construct(array $containerConfig, array $viewConfig)
    {
        $this->loadEnvConfig();
        $this->container = new Container($containerConfig);
        $this->configureContainer($viewConfig);
        $this->app = new App($this->container);
        $this->bindRoutes();
    }

    private function configureContainer(array $viewConfig)
    {
        $this->container['entityManager'] = (new EntityManager())->getEntityManager();
        $this->container['auth'] = new Auth($this->container);
        $container = $this->container;
        $this->container['view'] = function ($container) use ($viewConfig) {
            $view = new \Slim\Views\Twig(__DIR__.'/../View', $viewConfig);

            // Instantiate and add Slim specific extension
            $router = $container->get('router');
            $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
            $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));
            // This line should allow the use of {{ dump() }}
            //$view->addExtension(new Twig\Extension\DebugExtension());
            $view->getEnvironment()->addGlobal('auth', $container->get('auth'));
            return $view;
        };
    }

    private function bindRoutes()
    {
        // User routes
        $app = &$this->app;
        $this->app->group("/users", function () use (&$app){
            $app->get('', UserController::class.":index");

            $app->get('/profile', UserController::class.':profile')
                ->add(new AuthMiddleware($app->getContainer()));
            $app->get('/profile/edit', UserController::class.':editProfile')
                ->add(new AuthMiddleware($app->getContainer()));

            $app->get('/{id:[0-9]+}',UserController::class.':show')
                ->add(new AuthMiddleware($app->getContainer()));
        });

        // Auth routes
        $this->app->get('/login', AuthenticationController::class.':login')
            ->setName('login');
        $this->app->post('/login', AuthenticationController::class.':login');

        $this->app->map(['GET', 'POST'], '/registration', AuthenticationController::class.':register')
            ->add(new GuestMiddleware($this->app->getContainer()));

        $this->app->get('/logout', AuthenticationController::class.':logout')
            ->setName('logout');

        // Static Pages routes
        $this->app->get('/', PageController::class.':home')
            ->setName('home');
        $this->app->get('/about', PageController::class.':about');

    }

    private function loadEnvConfig()
    {
        $dotenv = Dotenv::create(__DIR__."/../..");
        $dotenv->overload();
    }

    public function run()
    {
        $this->app->run();
    }
}