<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use StaticDeploy\Entity\Base;

/**
 * App
 *
 * @ORM\Table(name="app")
 * @ORM\Entity
 */
class App extends Base
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    protected $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="config", type="text", length=65535, nullable=false)
     */
    protected $config;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     */
    protected $deleted = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="deletedByUserId", type="integer", nullable=false)
     */
    protected $deletedByUserId = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime", nullable=false)
     */
    protected $createdDate = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="createdByUserId", type="string", length=64, nullable=false)
     */
    protected $createdByUserId = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedDate", type="datetime", nullable=false)
     */
    protected $updatedDate = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="updatedByUserId", type="string", length=64, nullable=false)
     */
    protected $updatedByUserId = 0;

    /**
     * @var array
     */
    protected $propertyWhiteList = [
        'name',
        'config'
    ];

    /**
     * Get appId
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return App
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set config
     *
     * @param string $config
     *
     * @return App
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config
     *
     * @return string
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return App
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set deletedByUserId
     *
     * @param integer $deletedByUserId
     *
     * @return App
     */
    public function setDeletedByUserId($deletedByUserId)
    {
        $this->deletedByUserId = $deletedByUserId;

        return $this;
    }

    /**
     * Get deletedByUserId
     *
     * @return integer
     */
    public function getDeletedByUserId()
    {
        return $this->deletedByUserId;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return App
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set createdByUserId
     *
     * @param string $createdByUserId
     *
     * @return App
     */
    public function setCreatedByUserId($createdByUserId)
    {
        $this->createdByUserId = $createdByUserId;

        return $this;
    }

    /**
     * Get createdByUserId
     *
     * @return string
     */
    public function getCreatedByUserId()
    {
        return $this->createdByUserId;
    }

    /**
     * Set updatedDate
     *
     * @param \DateTime $updatedDate
     *
     * @return App
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updatedDate = $updatedDate;

        return $this;
    }

    /**
     * Get updatedDate
     *
     * @return \DateTime
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * Set updatedByUserId
     *
     * @param string $updatedByUserId
     *
     * @return App
     */
    public function setUpdatedByUserId($updatedByUserId)
    {
        $this->updatedByUserId = $updatedByUserId;

        return $this;
    }

    /**
     * Get updatedByUserId
     *
     * @return string
     */
    public function getUpdatedByUserId()
    {
        return $this->updatedByUserId;
    }
}
