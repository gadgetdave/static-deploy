<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use MyApp\Controller\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->viewConfig = [
            'title' => 'Admin Dashboard',
            'state' => [
                'otherwiseUrl' => '/',
                'config' => [
                    'index' => [
                        'url' => "/",
                        'templateUrl' => '/assets/views/index.html'
                    ]
                ]
            ]
        ];
    }
    
    public function indexAction()
    {
        return $this->returnNgView();
    }
}
