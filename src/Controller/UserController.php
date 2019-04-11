<?php


namespace App\Controller;


use App\Model\User;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use Exception;
use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;


class UserController extends BaseController
{

    private $userRepository;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    public function index(Request $request, Response $response, $args)
    {
        $users = $this->userRepository->findAll();
        $this->view->render($response,"user/index.twig", ['users' => $users]);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param $args
     * @throws Exception
     */
    public function show(Request $request, Response $response, $args)
    {
        try {
            $id = $args['id'];
            $user = $this->entityManager->find(User::class, $id);
            $this->view->render($response,"user/show.twig", ['user' => $user]);
        } catch (Exception $e) {
            throw $e;
        }
    }

}