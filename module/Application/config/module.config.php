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
//        'display_not_found_reason' => true,
//        'display_exceptions'       => true,
        'doctype' => 'HTML5',
//        'template_map' => array(
//        ),
//        'template_path_stack' => array(
//            __DIR__ . '/../view',
//        ),
    ),
    // Placeholder for console routes
//    'console' => array(
//        'router' => array(
//            'routes' => array(
//            ),
//        ),
//    ),
);
