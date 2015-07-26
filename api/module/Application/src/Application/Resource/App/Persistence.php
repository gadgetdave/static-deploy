<?php
namespace Application\Resource\App;

use StaticDeploy\Resource\AbstractPersistence;

class Persistence extends AbstractPersistence
{
    /**
     * @var string
     */
    protected $entityClass = 'Application\Entity\App';
}