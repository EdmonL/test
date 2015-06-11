<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'EYEReport\TemplateManager' => 'EYEReport\Template\TemplateManagerFactory',
        ),
    ),
    'eye_report' => array(
        'template_base_path' => __DIR__ . '/view/template',
        'template_suffix' => '.phtml',
        //'default_template_layout' => 'layout', // a path relative to the base path
        'templates' => array(
            'ta_summary' => array(
                'name' => 'TA Summary Report',
                'description' => 'An aggregate report at the organizational unit level',
                'layout' => 'ta_summary/layout', // a path relative to the base path
                'pages' => array( // path relative to the base path
                    'ta_summary/page1',
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
                        'page' => '[1-9][0-9]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'EYEReport\Controller',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Application\Controller\Template' => 'Application\Controller\TemplateControllerFactory',
        ),
    ),
);
