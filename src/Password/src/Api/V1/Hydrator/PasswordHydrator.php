<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Giona Guidotti <giona.guidotti@blackpoints.ch>
 */

namespace Password\Api\V1\Hydrator;

use Password\Api\V1\Entity\Password;
use Zend\Hydrator\AbstractHydrator;
use App\Service\DateConverter;

/**
 * Description of FolderHydrator
 */
class PasswordHydrator extends AbstractHydrator
{
    /**
     * Returns array based on Password's data
     *
     * @param Password $password
     * @return array
     */
    public function extract($password)
    {
        $data = [];
        $data['password_id'] = $password->getPasswordId();
        $data['title'] = $password->getTitle();
        $data['icon'] = $password->getIcon();
        if ($password->getCompletePassword()) {
            $data['folder_id'] = $password->getFolder()->getFolderId();
            $data['description'] = $password->getDescription();
            $data['username'] = $password->getUsername();
            $data['password'] = $password->getPassword();
            $data['url'] = $password->getUrl();
            $data['tags'] = $password->getTags();
            $data['fileId'] = $password->getFileId();
            $data['fileName'] = $password->getFileName();
            $data['usePin'] = $password->getUsePin();
            $data['last_modification_date'] = DateConverter::formatDateTime(
                $password->getLastModificationDate(),
                'outputDateTime'
            );
        }
        return $data;
    }

    public function hydrate(array $data, $password)
    {
        if (!$password instanceof Password) {
            return $password;
        }
        if ($this->isPropertyAvailable('title', $data)) {
            $password->setTitle($data['title']);
        }
        if ($this->isPropertyAvailable('icon', $data)) {
            $password->setIcon($data['icon']);
        }
        if ($this->isPropertyAvailable('description', $data)) {
            $password->setDescription($data['description']);
        }
        if ($this->isPropertyAvailable('username', $data)) {
            $password->setUsername($data['username']);
        }
        if ($this->isPropertyAvailable('password', $data)) {
            $password->setPassword($data['password']);
        }
        if ($this->isPropertyAvailable('url', $data)) {
            $password->setUrl($data['url']);
        }
        if ($this->isPropertyAvailable('tags', $data)) {
            $password->setTags($data['tags']);
        }
        if ($this->isPropertyAvailable('usePin', $data)) {
            $password->setUsePin($data['usePin']);
        } else {
            $password->setUsePin(false);
        }
        if ($this->isPropertyAvailable('last_modification_date', $data)) {
            $password->setLastModificationDate($data['last_modification_date']);
        }
        return $password;
    }

    protected function isPropertyAvailable($property, $data)
    {
        return isset($data[$property]);
    }
}
