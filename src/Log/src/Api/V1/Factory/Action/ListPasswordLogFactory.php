<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Giona Guidotti <giona.guidotti@blackpoints.ch>
 */

namespace Log\Api\V1\Factory\Action;

use Log\Api\V1\Action\ListPasswordLogAction;
use Psr\Container\ContainerInterface;
use Log\Api\V1\Facade\LogFacade;
use Mezzio\Hal\ResourceGeneratorFactory;

/**
 * Description of ListPasswordLogFactory
 */
class ListPasswordLogFactory
{
    /**
     * Invoke method, create instance of ListPasswordLogAction class
     *
     * @param ContainerInterface $container
     * @return ListPasswordLogAction
     */
    public function __invoke(ContainerInterface $container)
    {
        $halResourceGenerator = new ResourceGeneratorFactory();

        return new ListPasswordLogAction(
            $container->get(LogFacade::class),
            $halResourceGenerator($container),
            $container->get(\Mezzio\Hal\HalResponseFactory::class),
            $container->get("config")['paginator_config']
        );
    }
}
