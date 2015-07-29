<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use StaticDeploy\Entity\Base;

/**
 * OAuthClient
 *
 * @ORM\Table(name="oauth_clients", indexes={@ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class OAuthClient
{
    /**
     * @var integer
     *
     * @ORM\Column(name="client_id", type="string", length=80, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $client_id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    protected $client_secret;

    /**
     * @var string
     *
     * @ORM\Column(name="redirect_uri", type="string", length=2000, nullable=false)
     */
    protected $redirect_uri;

    /**
     * @var string
     *
     * @ORM\Column(name="grant_types", type="string", length=80, nullable=true)
     */
    protected $grant_types;

    /**
     * @var string
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    protected $user_id = 0;

    /**
     * @var array
     */
    protected $propertyWhiteList = [
        self::PROPERTY_WHITE_LIST_TYPE_GET => [
            'id',
            'firstName',
            'lastName',
            'jobTitle',
            'createdDate'
        ],
        self::PROPERTY_WHITE_LIST_TYPE_SET => [
            'firstName',
            'lastName',
            'jobTitle'
        ]
    ];

    /**
     * Set userId
     *
     * @return OAuthClient
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;

        return $this;
    }

    /**
     * Get client_id
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set client_secret
     *
     * @return OAuthClient
     */
    public function setClientSecret($clientSecret)
    {
        $this->client_secret = $clientSecret;

        return $this;
    }

    /**
     * Get client_secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * Set redirect_uri
     *
     * @return OAuthClient
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirect_uri = $redirectUri;

        return $this;
    }

    /**
     * Get redirect_uri
     *
     * @return OAuthClient
     */
    public function getRedirectUri($redirectUri)
    {
        return $this->redirect_uri;
    }

    /**
     * Set grant_types
     *
     * @return OAuthClient
     */
    public function setGrantTypes($grantTypes)
    {
        $this->grant_types = $grantTypes;

        return $this;
    }

    /**
     * Set grant_types
     *
     * @return OAuthClient
     */
    public function getGrantTypes()
    {
        return $this->grant_types;
    }

    /**
     * Set grant_types
     *
     * @return OAuthClient
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Set grant_types
     *
     * @return OAuthClient
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}
