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
use StaticDeploy\App\AppResourceListener;
use Application\App\AppPersistence;
use StaticDeploy\Resource\Resource;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    /* public function onRenderEntity($e)
    {
        $entity = $e->getParam('entity');
        if (! $entity->entity instanceof Base) {
            // do nothing
            return;
        }

        // Add a "describedBy" relational link
        $entity->getLinks()->add(\ZF\Hal\Link\Link::factory(array(
            'rel' => 'describedBy',
            'route' => array(
                'name' => 'my/api/docs',
            ),
        )));
    } */

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
                    $persistence = new AppPersistence($entityManager);
                    return new \Application\App\AppResourceListener($persistence);
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

                    $persistence = $services->get('AppResourceListener');
                    $events      = $services->get('EventManager');
                    $events->setIdentifiers('Application\App\AppResource');
                    $events->attach($persistence);

                    $resource    = new Resource();
                    $resource->setEventManager($events);

                    $controller = new \PhlyRestfully\ResourceController('AppController');
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

                    return $controller;
                },
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
