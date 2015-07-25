<?php
namespace MyApp\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Json\Json;

trait ControllerTrait
{
    
    /**
     * Set the view template to 'ng-view' for angular front end
     *
     * @param ViewModel $view
     */
    protected function returnNgView($variables = [])
    {
        if (empty($variables)) {
            $variables = [];
        }
        
        $variables += [
            'appName' => 'myApp',
            'script' => 'var VIEW_DATA = ' . Json::encode($this->viewConfig) . ';'
        ];
        
        $view = new ViewModel($variables);
        $view->setTemplate('ng-view.phtml');
        return $view;
    }
}