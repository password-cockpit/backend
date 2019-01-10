<?php

/**
 * @package App\Validator
 * @see https://github.com/password-cockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/password-cockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Davide Bucher <davide.bucher@blackpoints.ch>
 */

namespace App\Factory\Validator;

use App\Validator\NoEntityExists;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;

class NoEntityExistsFactory
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        $entityManager = $container->get(EntityManagerInterface::class);
        return new NoEntityExists($options, $entityManager);
    }
}
