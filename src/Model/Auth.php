<?php


namespace App\Model;


use App\Model\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class Auth
{


    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var UserRepository
     */
    private $userRepository;
    public function __construct(ContainerInterface $container)
    {
        $this->entityManager = $container->get('entityManager');
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }
    public function user() : User
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
    public function isAuth() : bool
    {
        return isset($_SESSION['user']);
    }
    public function isGuest():bool {
        return !$this->isAuth();
    }
    public function attempt($login, $password): bool
    {
        $user = $this->userRepository->checkPassword($login, $password);
        if ($user) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }
    public function logout()
    {
        unset($_SESSION['user']);
    }

}