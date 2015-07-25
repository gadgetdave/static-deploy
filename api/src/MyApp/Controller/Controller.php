<?php
namespace MyApp\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

class Controller extends AbstractActionController
{
    use ControllerTrait;
    
    public function indexAction()
    {
        return $this->returnNgView();
    }
}