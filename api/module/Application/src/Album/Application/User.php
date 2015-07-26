<?php

namespace Album\Application;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={@ORM\Index(name="deleted", columns={"deleted"})})
 * @ORM\Entity
 */
class User
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=32, nullable=false)
     */
    private $firstname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=32, nullable=false)
     */
    private $lastname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="jobTitle", type="string", length=255, nullable=false)
     */
    private $jobtitle = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLoginDate", type="datetime", nullable=true)
     */
    private $lastlogindate = '0000-00-00 00:00:00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirmed", type="boolean", nullable=false)
     */
    private $confirmed = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="confCode", type="string", length=100, nullable=false)
     */
    private $confcode;

    /**
     * @var string
     *
     * @ORM\Column(name="resetToken", type="string", length=127, nullable=true)
     */
    private $resettoken;

    /**
     * @var string
     *
     * @ORM\Column(name="resetCode", type="string", length=127, nullable=true)
     */
    private $resetcode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="resetExpiryDate", type="datetime", nullable=false)
     */
    private $resetexpirydate = '0000-00-00 00:00:00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     */
    private $deleted;

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
     * @var integer
     *
     * @ORM\Column(name="createdByUserId", type="integer", nullable=false)
     */
    private $createdbyuserid = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedDate", type="datetime", nullable=false)
     */
    private $updateddate = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="updatedByUserId", type="integer", nullable=false)
     */
    private $updatedbyuserid = '0';


}

