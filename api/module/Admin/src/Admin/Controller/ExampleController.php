<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use MyApp\Controller\CrudController;
use MyApp\Controller\ViewConfig;
use MyApp\Controller\CrudRestfulController;

class ExampleController extends CrudRestfulController
{
    public function __construct()
    {
        $this->entityClass = 'Admin\\Entity\\Example';
        $this->identifierName = 'exampleId';
    }
}
