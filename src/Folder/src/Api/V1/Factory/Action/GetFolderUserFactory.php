<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Giona Guidotti <giona.guidotti@blackpoints.ch>
 */

namespace Folder\Api\V1\Factory\Action;

use Psr\Container\ContainerInterface;
use Folder\Api\V1\Facade\FolderUserFacade;
use Folder\Api\V1\Facade\FolderFacade;
use User\Api\V1\Facade\UserFacade;
use Expressive\Hal\ResourceGeneratorFactory;
use Folder\Api\V1\Action\GetFolderUserAction;
use Laminas\I18n\Translator\Translator;

/**
 * Description of GetFolderUserFactory
 */
class GetFolderUserFactory
{
    /**
     * Invoke method, create instance of GetFolderUserAction class
     *
     * @param ContainerInterface $container
     * @return GetFolderUserAction
     */
    public function __invoke(ContainerInterface $container)
    {
        $halResourceGenerator = new ResourceGeneratorFactory();

        return new GetFolderUserAction(
            $container->get(FolderUserFacade::class),
            $container->get(FolderFacade::class),
            $container->get(UserFacade::class),
            $container->get(Translator::class),
            $halResourceGenerator($container),
            $container->get(\Expressive\Hal\HalResponseFactory::class)
        );
    }
}
