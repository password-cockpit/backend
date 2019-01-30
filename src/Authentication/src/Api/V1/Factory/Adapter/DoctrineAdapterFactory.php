<?php

namespace Authentication\Api\V1\Factory\Adapter;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Authentication\Api\V1\Adapter\DoctrineAdapter;

class DoctrineAdapterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        /**
         * Invoke method, create instance of DoctrineAdapter class
         *
         * @param ContainerInterface $container
         * @return DoctrineAdapter
         */
        return new DoctrineAdapter(
            $container->get(EntityManagerInterface::class)
        );
    }
}
