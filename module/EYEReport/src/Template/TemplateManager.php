<?php
/**
 * TemplateManager.php
 * Author: meng
 * Date: 10/06/2015
 * Time: 2:48 PM
 */

namespace EYEReport\Template;

use \Zend\View\Resolver\TemplateMapResolver;


class TemplateManager implements TemplateManagerInterface
{
    protected $config;

    public function __construct($config)
    {

    }

    public function getTemplate($key)
    {
        return new Template($this->config[$key]);
    }
}