<?php
namespace Application\App;

use MyApp\Resource\AbstractPersistence;

class AppPersistence extends AbstractPersistence
{
    /**
     * @var string
     */
    protected $entityClass = 'Application\Entity\App';
}