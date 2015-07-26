<?php
namespace Application\App;

use StaticDeploy\Resource\AbstractPersistence;

class AppPersistence extends AbstractPersistence
{
    /**
     * @var string
     */
    protected $entityClass = 'Application\Entity\App';
}