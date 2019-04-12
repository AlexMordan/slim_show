<?php


namespace App\Model;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * Class User
 * @package App\Model
 * @Table(name="users")
 * @Entity(repositoryClass="App\Model\Repository\UserRepository")
 */
class User
{
    public const ROLE_USER = "USER_ROLE";
    public const ROLE_ADMIN = "ADMIN_ROLE";
    public const ROLE_MANAGER = "MANAGER_ROLE";
    public const LIST_ROLES = [self::ROLE_ADMIN, self::ROLE_MANAGER, self::ROLE_USER];

    /**
     * @var int
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;
    /**
     * @Column(type="string")
     * @var string
     */
    protected $login;
    /**
     * @Column(type="string")
     * @var string
     */
    protected $email;
    /**
     * @Column(type="string")
     * @var string
     */
    protected $password;
    /**
     * @Column(type="string", nullable=true)
     * @var ?string
     */
    protected $fullName;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $role;
    /**
     * @var ?string
     * @Column(type="string", nullable=true)
     */
    protected $avatar;

    /** @Embedded(class = "Address") */
    protected $address;




    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        if(in_array($role,self::LIST_ROLES)) {
            $this->role = $role;
        }else
        {
            throw new \InvalidArgumentException("bad role value");
        }
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }



}

