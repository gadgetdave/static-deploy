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
            /* 'adminHome' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin/',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ), */
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /Admin/:controller/:action
            'Admin' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/admin[/]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                /* 'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/admin/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ), */
            ),
            /* 'album' => array(
                            'type'    => 'segment',
                            'options' => array(
                                            'route'    => '/album[/:id]',
                                            'constraints' => array(
                                                            'id'     => '[0-9]+',
                                            ),
                                            'defaults' => array(
                                                            'controller' => 'AlbumApi\Controller\Album',
                                            ),
                            ),
            ), */
            'admin_example' => [
                 'type'=> 'segment',
                 'options' => [
                     'route' => '/admin/example[/:exampleId]',
                     'constraints' => [
                         'exampleId' => '[0-9]+',
                     ],
                     'defaults' => [
                         'controller' => 'Admin\Controller\Example',
//                          'action' => 'index',
                     ],
                 ],
             ],
             /* 'admin_example_view' => [
                 'type'=> 'segment',
                 'options' => [
                     'route' => '/admin/example/:exampleId',
                     'constraints' => [
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'exampleId' => '[0-9]+',
                     ],
                     'defaults' => [
                         'controller' => 'Admin\Controller\Example',
                         'action' => 'view',
                     ],
                 ],
             ], */

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
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Example' => 'Admin\Controller\ExampleController'
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
    /* 'assetic_configuration' => array(
        'debug' => true,
        'buildOnRequest' => true,

        'webPath' => realpath('public/assets'),
        'basePath' => 'assets',

        'routes' => array(
            'home' => array(
                '@base_js',
                '@base_css',
            ),
        ),

        'modules' => array(
            'admin' => array(
                'root_path' => __DIR__ . '/../assets',
                'collections' => array(
                    'base_css' => array(
                        'assets' => array(
                        ),
                        'filters' => array(
                            'CssRewriteFilter' => array(
                                'name' => 'Assetic\Filter\CssRewriteFilter'
                            )
                        ),
                    ),

                    'base_js' => array(
                        'assets' => array(
                        )
                    ),

                    'base_images' => array(
                        'assets' => array(
                            'img/*.png',
                            'img/*.ico',
                        ),
                        'options' => array(
                            'move_raw' => true,
                        )
                    ),
                ),
            ),
        ),
    ), */
    'doctrine' => array(
      'driver' => array(
        'application_entities' => array(
          'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
          'cache' => 'array',
          'paths' => array(__DIR__ . '/../src/Admin/Entity')
        ),

        'orm_default' => array(
          'drivers' => array(
            'Admin\Entity' => 'application_entities'
          )
    )))

);
