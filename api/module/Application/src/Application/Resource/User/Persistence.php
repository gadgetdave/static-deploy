<?php
namespace Application\Resource\User;

use StaticDeploy\Resource\AbstractPersistence;

class Persistence extends AbstractPersistence
{
    /**
     * @var string
     */
    protected $entityClass = 'Application\Entity\User';
}