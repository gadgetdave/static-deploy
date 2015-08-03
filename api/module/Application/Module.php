<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use StaticDeploy\Entity\Base;
use Application\Resource\App\Persistence as AppPersistence;
use Application\Resource\User\Persistence as UserPersistence;
use StaticDeploy\Resource\Resource;
use OAuth2\Server;
use OAuth2\Request as OAuth2Request;
use Zend\Console\Console;
use StaticDeploy\Controller\ResourceController;
use Zend\Debug\Debug;
use Zend\Stdlib\Parameters;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AppResourceListener' => function ($services) {
                    $entityManager = $services->get('\Doctrine\ORM\EntityManager');
                    $oAuth2ServerFactory = $services->get('ZF\OAuth2\Service\OAuth2Server');
                    $persistence = new AppPersistence($entityManager, $oAuth2ServerFactory);
                    return new \Application\Resource\App\ResourceListener($persistence);
                },
                'UserResourceListener' => function ($services) {
                    $entityManager = $services->get('\Doctrine\ORM\EntityManager');
                    $oAuth2ServerFactory = $services->get('ZF\OAuth2\Service\OAuth2Server');
                    $persistence = new UserPersistence($entityManager, $oAuth2ServerFactory);
                    return new \Application\Resource\User\ResourceListener($persistence);
                },
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'AppController' => function ($controllers) {
                    $services    = $controllers->getServiceLocator();

                    $persistence = $services->get('App\ResourceListener');
                    $events      = $services->get('EventManager');
                    $events->attach($persistence);

                    $resource    = new Resource();
                    $resource->setEventManager($events);

                    $oAuth2Server = $services->get('ZF\OAuth2\Service\OAuth2Server');
                    $controller = new ResourceController($oAuth2Server, 'AppController');
                    $controller->setResource($resource);
                    $controller->setRoute('app');
                    $controller->setIdentifierName('id');
                    $controller->setCollectionName('apps');
                    $controller->setPageSize(20);
                    $controller->setCollectionHttpOptions(array(
                        'GET',
                        'POST',
                    ));
                    $controller->setResourceHttpOptions(array(
                        'GET',
                        'PUT',
                        'DELETE'
                    ));

                    $sharedEvents = $events->getSharedManager();
                    $sharedEvents->attach('AppController', 'getList.pre', function ($e) {
                        $e->getTarget()->getResource()->setQueryParams(
                            new Parameters($e->getTarget()->params()->fromQuery())
                        );
                    });
                    return $controller;
                },
                'UserController' => function ($controllers) {
                    $services    = $controllers->getServiceLocator();

                    $persistence = $services->get('User\ResourceListener');
                    $events      = $services->get('EventManager');
                    $events->attach($persistence);

                    $resource    = new Resource();
                    $resource->setEventManager($events);

                    $oAuth2Server = $services->get('ZF\OAuth2\Service\OAuth2Server');
                    $controller = new ResourceController($oAuth2Server, 'UserController');
                    $controller->setResource($resource);
                    $controller->setRoute('user');
                    $controller->setIdentifierName('id');
                    $controller->setCollectionName('users');
                    $controller->setPageSize(20);
                    $controller->setCollectionHttpOptions(array(
                        'GET',
                        'POST',
                    ));
                    $controller->setResourceHttpOptions(array(
                        'GET',
                        'PUT',
                        'DELETE'
                    ));
                    $sharedEvents = $events->getSharedManager();
                    $sharedEvents->attach('AppController', 'getList.pre', function ($e) {
                        $e->getTarget()->getResource()->setQueryParams(
                            new Parameters($e->getTarget()->params()->fromQuery())
                        );
                    });
                    
                    return $controller;
                },
                'AuthController' => function ($controllers) {
                    $services    = $controllers->getServiceLocator();

                    $persistence = $services->get('OAuthClient\ResourceListener');
                    $events      = $services->get('EventManager');
                    $events->attach($persistence);

                    $resource    = new Resource();
                    $resource->setEventManager($events);

                    $oAuth2Server = $services->get('ZF\OAuth2\Service\OAuth2Server');
                    $controller = new ResourceController($oAuth2Server, 'AuthController');
                    $controller->setResource($resource);
                    $controller->setRoute('auth');
                    $controller->setIdentifierName('user_id');
                    $controller->setPageSize(20);
                    $controller->setCollectionHttpOptions(array(
                    ));
                    $controller->setResourceHttpOptions(array(
                        'POST'
                    ));
                    $sharedEvents = $events->getSharedManager();
                    $sharedEvents->attach('AppController', 'getList.pre', function ($e) {
                        $e->getTarget()->getResource()->setQueryParams(
                            new Parameters($e->getTarget()->params()->fromQuery())
                        );
                    });
                    
                    return $controller;
                }
            ),
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
