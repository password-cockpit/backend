<?php

/**
 * Description of PermissionFacadeFactory
 *
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Giona Guidotti <giona.guidotti@blackpoints.ch>
 */

namespace User\Api\V1\Factory\Facade;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use User\Api\V1\Facade\PermissionFacade;
use User\Api\V1\Facade\UserFacade;
use Laminas\I18n\Translator\Translator;

class PermissionFacadeFactory
{
    /**
     * Invoke method, create instance of PermissionFacade class
     *
     * @param ContainerInterface $container
     * @return PermissionFacade
     */
    public function __invoke(ContainerInterface $container)
    {
        return new PermissionFacade(
            $container->get(EntityManagerInterface::class),
            $container->get(Translator::class),
            $container->get(UserFacade::class)
        );
    }
}
