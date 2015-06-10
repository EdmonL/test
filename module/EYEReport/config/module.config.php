<?php
return array(
    'eye_report' => array(
        'template_path' => __DIR__ . '/view/template',
        'default_template_suffix' => '.phtml',
        'templates' => array(
            'ta_summary' => array(
                'name' => 'TA Summary Report',
                'description' => 'An aggregate report at the organizational unit level',
                'pages' => array(
                    'page1',
                ),
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'eye_report' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/report/:controller/:action/:template[/:language][/:page]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z_]*',
                        'action' => '[a-zA-Z][a-zA-Z_]*',
                        'template' => '[a-zA-Z][a-zA-Z_]*',
                        'language' => '[a-zA-Z]+(_[a-zA-Z]+)?',
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'EYEReport\Controller',
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
);
