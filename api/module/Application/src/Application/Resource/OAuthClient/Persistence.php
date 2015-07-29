<?php
namespace Application\Resource\OAuthClient;

use StaticDeploy\Resource\AbstractPersistence;

class Persistence extends AbstractPersistence
{
    /**
     * @var string
     */
    protected $entityClass = 'Application\Entity\OAuthClient';
}