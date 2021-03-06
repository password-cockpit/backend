<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Davide Bucher <davide.bucher@blackpoints.ch>
 */

namespace Authorization\Api\V1\Factory\Assertion;

use Interop\Container\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Folder\Api\V1\Facade\FolderUserFacade;
use Authorization\Api\V1\Assertion\FileManageAssertion;
use Laminas\I18n\Translator\Translator;

class FileManageAssertionFactory
{
    /**
     * Invoke method, create instance of FileManageAssertion class
     *
     * @param ContainerInterface $container
     * @return FileManageAssertion
     */
    public function __invoke(ContainerInterface $container)
    {
        return new FileManageAssertion(
            $container->get(EntityManagerInterface::class),
            $container->get(Translator::class),
            $container->get(FolderUserFacade::class)
        );
    }
}
