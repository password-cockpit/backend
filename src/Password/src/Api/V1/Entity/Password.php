<?php

/**
 * @see https://github.com/password-cockpit/backend for the canonical source repository
 * @copyright Copyright (c) 2018 Blackpoints AG (https://www.blackpoints.ch)
 * @license https://github.com/password-cockpit/backend/blob/master/LICENSE.md BSD 3-Clause License
 */

namespace Password\Api\V1\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;

/**
 * Password
 *
 * @ORM\Table(name="password", indexes={@ORM\Index(name="fk_password_folder1_idx", columns={"folder_id"})})
 * @ORM\Entity
 * @SWG\Definition(definition="Password")
 */
class Password
{
    /**
     * @var int
     *
     * @ORM\Column(name="password_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @SWG\Property
     */
    private $passwordId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, precision=0, scale=0, nullable=false, unique=false)
     *
     * @SWG\Property(property="title", type="string", description="Password's title", example="title")
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="icon", type="string", length=45, precision=0, scale=0, nullable=true, unique=false)
     *
     * @SWG\Property(property="icon", type="string", description="Password's icon", example="icon")
     */
    private $icon;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=4000, precision=0, scale=0, nullable=true, unique=false)
     *
     * @SWG\Property(property="description", type="string", description="Password's description", example="description")
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     *
     * @SWG\Property(property="username", type="string", description="Password's username", example="username")
     */
    private $username;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=1000, precision=0, scale=0, nullable=true, unique=false)
     *
     * @SWG\Property(property="password", type="string", description="Password's password", example="password")
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     *
     * @SWG\Property(property="url", type="string", description="Password's url", example="http://www.blackpoints.ch")
     */
    private $url;

    /**
     * @var string|null
     *
     * @ORM\Column(name="tags", type="string", length=400, precision=0, scale=0, nullable=true, unique=false)
     *
     * @SWG\Property(property="tags", type="string", description="Password's tags", example="tag1 tag2 tag3")
     */
    private $tags;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_modification_date", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     *
     * @SWG\Property
     */
    private $lastModificationDate;

    /**
     * @var Folder\Api\V1\Entity\Folder
     *
     * @ORM\ManyToOne(targetEntity="Folder\Api\V1\Entity\Folder", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="folder_id", referencedColumnName="folder_id", nullable=true)
     * })
     *
     * @SWG\Property(property="folder_id", example=4)
     */
    private $folder;

    /**
     *
     *
     * @var boolean
     */
    private $completePassword = true;

    /**
     * @var int
     */
    private $fileId;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @return int
     */
    function getFileId()
    {
        return $this->fileId;
    }

    /**
     * @return string
     */
    function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param int $fileId
     */
    function setFileId($fileId)
    {
        $this->fileId = $fileId;
    }

    /**
     * @param string $fileName
     */
    function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     *
     * @return boolean
     */
    function getCompletePassword()
    {
        return $this->completePassword;
    }

    /**
     *
     */
    function setCompletePassword()
    {
        $this->completePassword = false;
    }

    /**
     * Get passwordId.
     *
     * @return int
     */
    public function getPasswordId()
    {
        return $this->passwordId;
    }

    /**
     * Set title.
     *
     * @param string|null $title
     *
     * @return Password
     */
    public function setTitle($title = null)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set icon.
     *
     * @param string|null $icon
     *
     * @return Password
     */
    public function setIcon($icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon.
     *
     * @return string|null
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return Password
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set username.
     *
     * @param string|null $username
     *
     * @return Password
     */
    public function setUsername($username = null)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password.
     *
     * @param string|null $password
     *
     * @return Password
     */
    public function setPassword($password = null)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set url.
     *
     * @param string|null $url
     *
     * @return Password
     */
    public function setUrl($url = null)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set tags.
     *
     * @param string|null $tags
     *
     * @return Password
     */
    public function setTags($tags = null)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags.
     *
     * @return string|null
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set lastModificationDate.
     *
     * @param \DateTime|null $lastModificationDate
     *
     * @return Password
     */
    public function setLastModificationDate($lastModificationDate = null)
    {
        $this->lastModificationDate = $lastModificationDate;

        return $this;
    }

    /**
     * Get lastModificationDate.
     *
     * @return \DateTime|null
     */
    public function getLastModificationDate()
    {
        return $this->lastModificationDate;
    }

    /**
     * Set folder.
     *
     * @param \Folder\Api\V1\Entity\Folder|null $folder
     *
     * @return Password
     */
    public function setFolder(\Folder\Api\V1\Entity\Folder $folder = null)
    {
        $this->folder = $folder;

        return $this;
    }

    /**
     * Get folder.
     *
     * @return \Folder\Api\V1\Entity\Folder|null
     */
    public function getFolder()
    {
        return $this->folder;
    }
}
