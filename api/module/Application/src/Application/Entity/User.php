<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use StaticDeploy\Entity\Base;

/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})}, indexes={@ORM\Index(name="deleted", columns={"deleted"})})
 * @ORM\Entity
 */
class User extends Base
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
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    protected $email = '';

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64, nullable=true)
     */
    protected $password;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=32, nullable=false)
     */
    protected $firstName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=32, nullable=false)
     */
    protected $lastName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="jobTitle", type="string", length=255, nullable=false)
     */
    protected $jobTitle = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    protected $active = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastLoginDate", type="datetime", nullable=true)
     */
    protected $lastLoginDate = '0000-00-00 00:00:00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirmed", type="boolean", nullable=false)
     */
    protected $confirmed = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="confCode", type="string", length=100, nullable=false)
     */
    protected $confCode;

    /**
     * @var string
     *
     * @ORM\Column(name="resetToken", type="string", length=127, nullable=true)
     */
    protected $resetToken;

    /**
     * @var string
     *
     * @ORM\Column(name="resetCode", type="string", length=127, nullable=true)
     */
    protected $resetCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="resetExpiryDate", type="datetime", nullable=false)
     */
    protected $resetExpiryDate = '0000-00-00 00:00:00';

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     */
    protected $deleted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdDate", type="datetime", nullable=false)
     */
    protected $createdDate = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="createdByUserId", type="integer", nullable=false)
     */
    protected $createdByUserId = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedDate", type="datetime", nullable=false)
     */
    protected $updatedDate = '0000-00-00 00:00:00';

    /**
     * @var integer
     *
     * @ORM\Column(name="updatedByUserId", type="integer", nullable=false)
     */
    protected $updatedByUserId = 0;

    /**
     * @var array
     */
    protected $propertyWhiteList = [
        'firstName',
        'lastName',
        'jobTitle'
    ];

    /**
     * Get userId
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set jobTitle
     *
     * @param string $jobTitle
     *
     * @return User
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * Get jobTitle
     *
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return User
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set lastLoginDate
     *
     * @param \DateTime $lastLoginDate
     *
     * @return User
     */
    public function setLastLoginDate($lastLoginDate)
    {
        $this->lastLoginDate = $lastLoginDate;

        return $this;
    }

    /**
     * Get lastLoginDate
     *
     * @return \DateTime
     */
    public function getLastLoginDate()
    {
        return $this->lastLoginDate;
    }

    /**
     * Set confirmed
     *
     * @param boolean $confirmed
     *
     * @return User
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * Get confirmed
     *
     * @return boolean
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Set confCode
     *
     * @param string $confCode
     *
     * @return User
     */
    public function setConfCode($confCode)
    {
        $this->confCode = $confCode;

        return $this;
    }

    /**
     * Get confCode
     *
     * @return string
     */
    public function getConfCode()
    {
        return $this->confCode;
    }

    /**
     * Set resetToken
     *
     * @param string $resetToken
     *
     * @return User
     */
    public function setResetToken($resetToken)
    {
        $this->resetToken = $resetToken;

        return $this;
    }

    /**
     * Get resetToken
     *
     * @return string
     */
    public function getResetToken()
    {
        return $this->resetToken;
    }

    /**
     * Set resetCode
     *
     * @param string $resetCode
     *
     * @return User
     */
    public function setResetCode($resetCode)
    {
        $this->resetCode = $resetCode;

        return $this;
    }

    /**
     * Get resetCode
     *
     * @return string
     */
    public function getResetCode()
    {
        return $this->resetCode;
    }

    /**
     * Set resetExpiryDate
     *
     * @param \DateTime $resetExpiryDate
     *
     * @return User
     */
    public function setResetExpiryDate($resetExpiryDate)
    {
        $this->resetExpiryDate = $resetExpiryDate;

        return $this;
    }

    /**
     * Get resetExpiryDate
     *
     * @return \DateTime
     */
    public function getResetExpiryDate()
    {
        return $this->resetExpiryDate;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     *
     * @return User
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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return User
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
     * Set createdby
     *
     * @param string $createdby
     *
     * @return User
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby
     *
     * @return string
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set createdByUserId
     *
     * @param integer $createdByUserId
     *
     * @return User
     */
    public function setCreatedByUserId($createdByUserId)
    {
        $this->createdByUserId = $createdByUserId;

        return $this;
    }

    /**
     * Get createdByUserId
     *
     * @return integer
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
     * @return User
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
     * Set updatedby
     *
     * @param string $updatedby
     *
     * @return User
     */
    public function setUpdatedby($updatedby)
    {
        $this->updatedby = $updatedby;

        return $this;
    }

    /**
     * Get updatedby
     *
     * @return string
     */
    public function getUpdatedby()
    {
        return $this->updatedby;
    }

    /**
     * Set updatedByUserId
     *
     * @param integer $updatedByUserId
     *
     * @return User
     */
    public function setUpdatedByUserId($updatedByUserId)
    {
        $this->updatedByUserId = $updatedByUserId;

        return $this;
    }

    /**
     * Get updatedByUserId
     *
     * @return integer
     */
    public function getUpdatedByUserId()
    {
        return $this->updatedByUserId;
    }
}
