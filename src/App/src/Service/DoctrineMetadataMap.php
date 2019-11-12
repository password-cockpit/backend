<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 */

namespace App\Service;

/**
 *
 * This class is responsible to resolve the namespace of the proxy object to get
 * the real one. In Doctrine when a fetch is executed all object retrieved with
 * a lazy-loading mode are incapsulated in a proxy object which cause some
 * problem when it's used with functionality of \Expressive\Hal\Metadata\MetadataMap
 * that map the class name with the configuration of the response generator.
 *
 */
class DoctrineMetadataMap extends \Expressive\Hal\Metadata\MetadataMap
{
    /**
     *
     * @param string $class
     */
    public function has(string $class) : bool
    {
        $class = \Doctrine\Common\Util\ClassUtils::getRealClass($class);
        return parent::has($class);
    }

    public function get(
        string $class
    ) : \Expressive\Hal\Metadata\AbstractMetadata {
        $class = \Doctrine\Common\Util\ClassUtils::getRealClass($class);
        return parent::get($class);
    }
}
