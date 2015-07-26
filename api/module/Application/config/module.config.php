<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'app' => [
                 'type'=> 'segment',
                 'options' => [
                     'route' => '/app[/:appId]',
                     'constraints' => [
                         'appId' => '[0-9]+',
                     ],
                     'defaults' => [
                         'controller' => 'Application\Controller\App',
                     ],
                 ],
             ],
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\App' => 'Application\Controller\AppController'
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        /* 'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ), */
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    'doctrine' => array(
      'driver' => array(
        'application_entities' => array(
          'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
          'cache' => 'array',
          'paths' => array(__DIR__ . '/../src/Application/Entity')
        ),

        'orm_default' => array(
          'drivers' => array(
            'Application\Entity' => 'application_entities'
          )
    ))),
    'zf-content-negotiation' => array(
        'selectors' => array(
            'HalJson' => array(
                'ZF\Hal\View\HalJsonModel' => array(
                    'application/json',
                    'application/*+json',
                ),
            ),
        ),
    ),
    'phlyrestfully' => array(
        'resources' => array(
            'MyApp\App\ApiController' => array(
                'identifier'              => 'Apps',
                'listener'                => 'MyApp\App\AppResourceListener',
                'resource_identifiers'    => array('AppResource'),
                'collection_http_options' => array('get', 'post'),
                'collection_name'         => 'apps',
                'page_size'               => 10,
                'resource_http_options'   => array('get'),
                'route_name'              => 'apps',
            ),
        ),
    ),
);
