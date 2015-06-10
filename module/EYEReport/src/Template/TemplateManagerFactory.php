<?php
/**
 * TemplateManagerFactory.php
 * Author: meng
 * Date: 10/06/2015
 * Time: 2:34 PM
 */

namespace EYEReport\Template;

use \Zend\ServiceManager\ServiceLocatorInterface;

class TemplateManagerFactory implements \Zend\ServiceManager\FactoryInterface
{
    /**
     * Create the template manager
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TemplateManager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $defaultTemplateSuffix = '';
        $templatePath = '';
        $map = array();
        if (is_array($config)) {
            if (isset($config['view_manager'])) {
                $viewConfig = $config['view_manager'];
                if (is_array($viewConfig) && isset($viewConfig['default_template_suffix'])) {
                    $defaultTemplateSuffix = $viewConfig['default_template_suffix'];
                }
            }
            if (isset($config['eye_report'])) {
                $config = $config['eye_report'];
                if (is_array($config)) {
                    if (isset($config['template_path'])) {
                        $templatePath = $config['template_path'];
                    }
                    if (isset($config['default_template_suffix'])) {
                        $defaultTemplateSuffix = $config['default_template_suffix'];
                    }
                    if (isset($config['templates']) && is_array($map)) {
                        $map = $config['templates'];
                    }
                }
            }
        }
        if (!empty($defaultTemplateSuffix)) {
            $defaultTemplateSuffix = (string)$defaultTemplateSuffix;
            $defaultTemplateSuffix = '.' . ltrim($defaultTemplateSuffix, '.');
        }
        if (!is_string($templatePath)) {
            throw new \Exception\InvalidArgumentException(sprintf(
                'Invalid path provided; must be a string, received %s',
                gettype($templatePath)
            ));
        }
        $templatePath = static::normalizePath($templatePath);

        $viewTemplateMapResolver = $serviceLocator->get('ViewTemplateMapResolver');
        foreach ($map as $tk => $tv) {
            if (empty($tk) || !is_array($tv) || !isset($tv['pages'])) {
                unset($map[$tk]);
                continue;
            }
            if (!preg_match('[a-zA-Z][a-zA-Z_]*', $tk)) {
                throw new \Exception\InvalidArgumentException(sprintf(
                    'Invalid template %s; must be a string containing only letters and underscores, and starting with a letter',
                    (string)$tk
                ));
            }
            $pages = array_values($tv['pages']);
            $pageViews = array();
            foreach ($pages as $pageNum => $page) {
                if (empty($page)) {
                    throw new \Exception\InvalidArgumentException(sprintf(
                        'Invalid page in template %s; must not be empty', $tk
                    ));
                }
                $pageView = 'eye_report/template/' . $tk . '/' . ($pageNum + 1);
                $pageViews[] = $pageView;
                $viewTemplateMapResolver->add($pageView,
                    $templatePath . rtirm($page, $defaultTemplateSuffix) . $defaultTemplateSuffix
                );
            }
            $map[$tk]['pages'] = $pageViews;
        }

        return new TemplateManager($map);
    }

    /**
     * Normalize a path
     *
     * @param  string $path
     * @return string
     */
    public static function normalizePath($path)
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
        return rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }
}
