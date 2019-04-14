<?php

namespace App\Controller;

use App\Model\Repository\UserRepository;
use App\Model\User;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthenticationController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    public function login(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $params = $request->getParsedBody();
            $login = $params['inputLogin'];
            $password = $params['inputPassword'];
            if ($this->auth->attempt($login, $password)) {
                return $response->withRedirect('/');
            } else {
                return $this->view->render(
                    $response,
                    'auth/login.twig',
                    ['login' => $login, 'error' => 'Incorrect login or password']);
            }
        } else {

            return $this->view->render($response, 'auth/login.twig');
        }
    }

    public function logout(Request $request, Response $response)
    {
        $this->auth->logout();
        return $response->withRedirect('/');
    }

    public function register(Request $request, Response $response)
    {
        if ($request->isPost()) {
            return $this->postRegister($request, $response);
        }
        return $this->view->render($response, 'auth/register.twig');
    }

    private function postRegister(Request $request, Response $response)
    {
        $params = $request->getParsedBody();
        $login = $params['inputLogin'];
        $email = $params['inputEmail'];
        $password = $params['inputPassword'];

        $errors = $this->auth->validateRegistration($login, $email, $password);

        if (empty($errors)) {
            $user = $this->auth->register($login, $email, $password);
            $this->auth->loginByUser($user);
            return $response->withRedirect('/users/profile');

        } else {
            return $this->view->render(
                $response,
                'auth/register.twig',
                ['errors' => $errors, 'login' => $login, 'email' => $email]
            );
        }
    }
}