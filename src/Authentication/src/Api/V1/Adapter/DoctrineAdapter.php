<?php

namespace Authentication\Api\V1\Adapter;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Crypt\Password\Bcrypt;
use Zend\Authentication\Result;
use User\Api\V1\Entity\User;
use Doctrine\ORM\EntityManager;

class DoctrineAdapter implements AdapterInterface
{
    /**
     * @var string $username
     */
    private $username;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @var $entityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->username = null;
        $this->password = null;
        $this->entityManager = $entityManager;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function authenticate()
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['username' => $this->username]);
        if ($user) {
            $bcrypt = new Bcrypt();
            $securePass = $user->getPassword();
            if ($bcrypt->verify($this->password, $securePass)) {
                //check if user is enabled
                if (!$user->getEnabled()) {
                    $result = new Result(-2, $user, []);
                    return $result;
                }
                // user information are correct
                $result = new Result(1, $user, []);
                return $result;
            } else {
                // wrong pass
                $result = new Result(0, $user, []);
                return $result;
            }
        } else {
            // user does not exist
            $result = new Result(0, null, []);
            return $result;
        }
    }
}
