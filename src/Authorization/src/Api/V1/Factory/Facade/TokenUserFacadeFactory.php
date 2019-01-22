<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Davide Bucher <davide.bucher@blackpoints.ch>
 */

namespace Authorization\Api\V1\Factory\Facade;

use Authorization\Api\V1\Facade\TokenUserFacade;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class TokenUserFacadeFactory
{
    /**
     * Invoke method
     *
     * @param ContainerInterface $container
     * @return DossierFacade
     */
    public function __invoke(ContainerInterface $container)
    {
        $entityManager = $container->get(EntityManagerInterface::class);

        return new TokenUserFacade($entityManager);
    }
}
