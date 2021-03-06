<?php

/**
 * Description of UserFacadeFactory
 *
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Giona Guidotti <giona.guidotti@blackpoints.ch>
 */

namespace Folder\Api\V1\Factory\Facade;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Folder\Api\V1\Facade\FolderFacade;
use Password\Api\V1\Facade\PasswordFacade;
use User\Api\V1\Facade\UserFacade;
use Laminas\I18n\Translator\Translator;

class FolderFacadeFactory
{
    /**
     * Invoke method, create instance of FolderFacade class
     *
     * @param ContainerInterface $container
     * @return FolderFacade
     */
    public function __invoke(ContainerInterface $container)
    {
        return new FolderFacade(
            $container->get(EntityManagerInterface::class),
            $container->get(Translator::class),
            $container->get(UserFacade::class)
        );
    }
}
