<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Davide Bucher <davide.bucher@blackpoints.ch>
 */

namespace Authentication\Api\V1\Factory\Action;

use Authentication\Api\V1\Action\AuthenticationLogout;
use Authentication\Api\V1\Facade\TokenUserFacade;
use Psr\Container\ContainerInterface;

class AuthenticationLogoutFactory
{
    /**
     * Invoke method, create instance of AuthenticationLogout class
     *
     * @param ContainerInterface $container
     * @return AuthenticationLogout
     */
    public function __invoke(ContainerInterface $container)
    {
        return new AuthenticationLogout(
            $container->get(TokenUserFacade::class)
        );
    }
}
