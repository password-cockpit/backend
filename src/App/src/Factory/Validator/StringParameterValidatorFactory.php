<?php

/**
 * @see https://github.com/password-cockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/password-cockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Davide Bucher <davide.bucher@blackpoints.ch>
 */

namespace App\Factory\Validator;

use App\Validator\StringParameterValidator;
use Psr\Container\ContainerInterface;
use Zend\InputFilter\InputFilterPluginManager;
use Zend\InputFilter\Factory as InputFilterFactory;

class StringParameterValidatorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $filter = new InputFilterFactory(
            $container->get(InputFilterPluginManager::class)
        );
        $translator = $container->get("translator");

        return new StringParameterValidator($filter, $translator);
    }
}
