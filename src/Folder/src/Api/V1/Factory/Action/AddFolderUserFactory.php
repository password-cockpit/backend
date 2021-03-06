<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Giona Guidotti <giona.guidotti@blackpoints.ch>
 */

namespace Folder\Api\V1\Factory\Action;

use Psr\Container\ContainerInterface;
use Folder\Api\V1\Facade\FolderFacade;
use User\Api\V1\Facade\UserFacade;
use Mezzio\Hal\ResourceGeneratorFactory;
use Folder\Api\V1\Action\AddFolderUserAction;
use Folder\Api\V1\Facade\FolderUserFacade;

/**
 * Description of AddFolderUserFactory
 */
class AddFolderUserFactory
{
    /**
     * Invoke method, create instance of AddFolderUserAction class
     *
     * @param ContainerInterface $container
     * @return AddFolderUserAction
     */
    public function __invoke(ContainerInterface $container)
    {
        $halResourceGenerator = new ResourceGeneratorFactory();

        return new AddFolderUserAction(
            $container->get(FolderFacade::class),
            $container->get(UserFacade::class),
            $container->get(FolderUserFacade::class),
            $halResourceGenerator($container),
            $container->get(\Mezzio\Hal\HalResponseFactory::class)
        );
    }
}
