<?php


namespace App\Controller\Middleware;


use App\Model\Auth;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class GuestMiddleware extends BaseMiddleware
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
    }

    public function __invoke(Request $request,Response $response, $next)
    {
        /** @var Auth $auth */
        $auth = $this->container->get('auth');
        /** @var PhpRenderer $view */
        $view = $this->container->get('view');
        if(! $auth->isGuest()) {
            //$this->container->view->getEnvironment()->addGlobal('message','Please sign in before doing that');
            //$this->container->flash->addMessage('error', 'Please sign in before doing that');
            return $response->withRedirect($this->container->router->pathFor('home'));
        }
        $response = $next($request, $response);
        return $response;
    }
}