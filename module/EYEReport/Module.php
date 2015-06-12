<?php
namespace EYEReport;

use EYEReport\Controller\TemplateController;
use Zend\Mvc\Controller\ControllerManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src',
                ),
            ),
        );
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'EYEReport\Controller\Template' => function (ControllerManager $cm) {
                    $tm = $cm->getServiceLocator()->get('EYEReport\TemplateManager');
                    return new TemplateController($tm);
                },
            ),
        );
    }
}

