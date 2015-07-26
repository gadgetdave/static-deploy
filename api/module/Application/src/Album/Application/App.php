<?php

namespace Album\Application;

use Doctrine\ORM\Mapping as ORM;

/**
 * App
 *
 * @ORM\Table(name="app", uniqueConstraints={@ORM\UniqueConstraint(name="name", columns={"name"})}, indexes={@ORM\Index(name="deleted", columns={"deleted"})})
 * @ORM\Entity
 */
class App
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="config", type="text", length=65535, nullable=false)
     */
    private $config;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     */
    private $deleted = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deletedDate", type="datetime", nullable=false)
     */
    private $deleteddate = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="deletedByUserId", type="integer", nullable=false)
     */
    private $deletedbyuserid = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime", nullable=false)
     */
    private $createddate = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="createdByUserId", type="string", length=64, nullable=false)
     */
    private $createdbyuserid = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedDate", type="datetime", nullable=false)
     */
    private $updateddate = '0000-00-00 00:00:00';

    /**
     * @var string
     *
     * @ORM\Column(name="updatedByUserId", type="string", length=64, nullable=false)
     */
    private $updatedbyuserid = '0';


}

