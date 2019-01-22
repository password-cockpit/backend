<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Davide Bucher <davide.bucher@blackpoints.ch>
 */

namespace Authorization\Api\V1\Facade;

use Doctrine\ORM\EntityManager;
use Authorization\Api\V1\Entity\TokenUser;
use User\Api\V1\Entity\User;

class TokenUserFacade
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Return a tokenUser
     *
     * @param string $token
     *
     * @return TokenUser|null
     *
     */
    public function getByToken($token)
    {
        $tokenUser = $this->entityManager
            ->getRepository(TokenUser::class)
            ->findBy(['token' => $token]);

        return $tokenUser;
    }

    /**
     * Return a tokenUser
     *
     * @param int $userId
     *
     * @return TokenUser|null
     *
     */
    public function getByUserId($userId)
    {
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findBy(['userId' => $userId]);

        $tokenUser = $this->entityManager
            ->getRepository(TokenUser::class)
            ->findBy(['user' => $user]);

        return $tokenUser;
    }

    public function create($user, $token)
    {
        $tokenUser = new TokenUser();
        $tokenUser->setUser($user);
        $tokenUser->setToken($token);
        $tokenUser->setLastLogin(
            new \Datetime("now", new \DateTimeZone('Europe/Zurich'))
        );

        $this->entityManager->persist($tokenUser);
        $this->entityManager->flush();

        return true;
    }

    public function updateTokenUser($tokenUser, $token)
    {
        $tokenUser->setToken($token);
        $tokenUser->setLastLogin(
            new \Datetime("now", new \DateTimeZone('Europe/Zurich'))
        );
        $this->entityManager->persist($tokenUser);
        $this->entityManager->flush();
    }

    public function deleteToken()
    {
    }
}
