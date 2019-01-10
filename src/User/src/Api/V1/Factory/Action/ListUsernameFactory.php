<?php

/**
 * @see https://github.com/password-cockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/password-cockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Giona Guidotti <giona.guidotti@blackpoints.ch>
 */

namespace User\Api\V1\Factory\Action;

use Psr\Container\ContainerInterface;
use User\Api\V1\Action\ListUsernameAction;
use User\Api\V1\Facade\UserFacade;
use Zend\Expressive\Hal\ResourceGeneratorFactory;

class ListUsernameFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $userFacade = $container->get(UserFacade::class);
        $halResourceGenerator = new ResourceGeneratorFactory();
        $halResourceGeneratorInstance = $halResourceGenerator($container);
        $halResponseFactory = $container->get(
            \Zend\Expressive\Hal\HalResponseFactory::class
        );
        return new ListUsernameAction(
            $userFacade,
            $halResourceGeneratorInstance,
            $halResponseFactory
        );
    }
}
