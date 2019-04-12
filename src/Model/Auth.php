<?php


namespace App\Model;


use App\Model\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

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

    public function register(string $login, string $email, string $password): ?User
    {
        $user = new User();
        $user->setLogin($login);
        $user->setEmail($email);
        $user->setPassword(password_hash($password,PASSWORD_DEFAULT));
        $user->setRole(User::ROLE_USER);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

    private function checkLoginAvailable(string $login):bool
    {
        return $this->userRepository->checkLoginAvailable($login);
    }
    private function checkEmailAvailable(string $email):bool
    {
        return $this->userRepository->checkEmailAvailable($email);
    }
    public function loginByUser(User $user)
    {
        $_SESSION['user'] = $user;
    }
    public function validateRegistration(string $login, string $email, string $password): array
    {
        $errors = [];

        try {
            v::alnum()
                ->noWhitespace()
                ->length(3, 15)
                ->setName('Login')
                ->assert($login);
        } catch (NestedValidationException $exception) {
            $errors[] = $exception->getFullMessage();
        } finally {
            try {
                v::email()
                    ->setName('Email')
                    ->assert($email);
            } catch (NestedValidationException $exception) {
                $errors[] = $exception->getFullMessage();
            } finally {
                try {
                    v::noWhitespace()
                        ->length(6, 15)
                        ->setName('password')
                        ->assert($password);
                } catch (NestedValidationException $exception) {
                    $errors[] = $exception->getFullMessage();
                }
            }
        }

        if(! $this->checkLoginAvailable($login))
        {
            $errors[] = 'Login already in use';
        }
        if(! $this->checkEmailAvailable($email))
        {
            $errors[] = 'Email already in use';
        }
        return $errors;
    }
}