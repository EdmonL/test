<?php
return array(
    'router' => array(
        'routes' => array(
            'application' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/:controller/:action',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z_]*',
                        'action' => '[a-zA-Z][a-zA-Z_]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Node' => 'Application\Controller\NodeController'
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
    ),
    'view_manager' => array(
        'doctype' => 'HTML5',
        'default_template_suffix' => 'phtml',
//        'template_path_stack' => array(
//            __DIR__ . '/../view',
//        ),
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            //'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
    ),
    // Placeholder for console routes
//    'console' => array(
//        'router' => array(
//            'routes' => array(
//            ),
//        ),
//    ),
);
