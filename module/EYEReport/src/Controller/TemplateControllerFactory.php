<?php
/**
 * TemplateControllerFactory.php
 * Author: meng
 * Date: 11/06/2015
 * Time: 2:12 PM
 */

namespace EYEReport\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TemplateControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tm = $serviceLocator->get('EYEReport\TemplateManager');
        return new TemplateController($tm);
    }
}