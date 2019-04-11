<?php

use App\Controller\UserController;
use Dotenv\Dotenv;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
session_start();

$dotenv = Dotenv::create(__DIR__."/../..");
$dotenv->overload();

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$container = new \Slim\Container($configuration);


// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__.'/../View', [
        'cache' => false,
        //'cache' => __DIR__.'/../Storage/Cache'
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container['entityManager'] = function (){
    return (new \App\Core\EntityManager())->getEntityManager();
};
$app = new \Slim\App($container);



$app->group("/users", function () use ($app){
    $app->get('', UserController::class.":index");
    $app->get('/{id:[0-9]+}',UserController::class.':show');
});


//$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
//    $name = $args['name'];
//    $response->getBody()->write("Hello, $name");
//
//    return $response;
//});

$app->get('/', function (){
    echo 'hello world';
});
$app->run();
