<?php

/**
 * @see https://github.com/passwordcockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/passwordcockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 * @author Davide Bucher <davide.bucher@blackpoints.ch>
 */

namespace Authorization\Api\V1\Assertion;

use Laminas\Permissions\Rbac\AssertionInterface;
use Psr\Http\Message\ServerRequestInterface;
use User\Api\V1\Entity\User;
use App\Service\ProblemDetailsException;
use Doctrine\ORM\EntityManager;
use Laminas\I18n\Translator\Translator;
use Folder\Api\V1\Facade\FolderUserFacade;
use Laminas\Permissions\Rbac\RoleInterface;

class UserAssertion implements AssertionInterface
{
    protected $translator;
    protected $folderUserFacade;
    protected $request;
    protected $user;

    /**
     * Constructor
     *
     * @param Translator $translator
     * @param FolderUserFacade $folderUserFacade
     */
    public function __construct(
        Translator $translator,
        FolderUserFacade $folderUserFacade
    ) {
        $this->translator = $translator;
        $this->folderUserFacade = $folderUserFacade;
    }

    /**
     * {@inheritDoc}
     */
    public function setRequest(
        \Psr\Http\Message\ServerRequestInterface $request
    ) {
        $this->request = $request;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Returns userId from Request attributes
     *
     * @param type $request
     * @return type
     */
    private function getUserId($request)
    {
        if ($request->getAttribute('userId')) {
            $userId = $request->getAttribute('userId');
        } else {
            $userId = $request->getAttribute('id');
        }
        return $userId;
    }

    /**
     * Function that gets called by the interface
     *
     * @param Rbac $rbac
     * @param RoleInterface $role
     * @param string $permission
     *
     * @return bool
     */
    public function assert(
        \Laminas\Permissions\Rbac\Rbac $rbac,
        RoleInterface $role,
        string $permission
    ): bool {
        $userIdRequest = $this->getUserId($this->request);
        $userId = $this->user->getUserId();
        if ($userIdRequest == $userId) {
            return true;
        }
        return false;
    }
}
