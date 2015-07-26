<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use MyApp\Controller\CrudController;
use MyApp\Controller\ViewConfig;
use MyApp\Controller\CrudRestfulController;

class AppController extends CrudRestfulController
{
    public function __construct()
    {
        $this->entityClass = 'Application\\Entity\\App';
        $this->identifierName = 'appId';
    }
}
