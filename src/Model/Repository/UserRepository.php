<?php


namespace App\Model\Repository;


use App\Model\User;
use Doctrine\ORM\EntityRepository;

class UserRepository  extends EntityRepository
{

    public function checkPassword(string $login, string $password) : ?User
    {
        /** @var User $user */
        $user = $this->findOneBy(['login' => $login]);
        if($user && password_verify($password,$user->getPassword()))
        {
            return $user;
        }
        return null;
    }
}