<?php

/**
 * @see https://github.com/password-cockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/password-cockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Giona Guidotti <giona.guidotti@blackpoints.ch>
 */

namespace User\Api\V1\Hydrator;

use Zend\Hydrator\AbstractHydrator;

/**
 * Description of UserPermissionHydrator
 */
class UserPermissionHydrator extends AbstractHydrator
{
    public function extract($userPermission)
    {
        $data = [];
        $data['user_id'] = $userPermission->getUser()->getUserId();
        $data['manage_users'] = $userPermission->getManageUsers();
        $data['create_folders'] = $userPermission->getCreateFolders();
        $data['access_all_folders'] = $userPermission->getAccessAllFolders();
        $data['view_logs'] = $userPermission->getViewLogs();
        return $data;
    }

    public function hydrate(array $data, $object): object
    {
    }
}
