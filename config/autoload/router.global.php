<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 */

use Expressive\Router\RouterInterface;
use Expressive\Router\LaminasRouter;

return [
    'dependencies' => [
        'invokables' => [
            RouterInterface::class => LaminasRouter::class
        ]
    ]
];
