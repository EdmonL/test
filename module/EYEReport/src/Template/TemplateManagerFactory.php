<?php
/**
 * TemplateManagerFactory.php
 * Author: meng
 * Date: 10/06/2015
 * Time: 2:34 PM
 */

namespace EYEReport\Template;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TemplateManagerFactory implements FactoryInterface
{
    /**
     * Create the template manager
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return TemplateManager
     * @throws \InvalidArgumentException if the config is invalid
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $viewTemplateMapResolver = $serviceLocator->get('ViewTemplateMapResolver');

        $templateBasePath = '';
        $templateSuffix = '';
        $map = array();

        if (is_array($config) && isset($config['eye_report'])) {
            $config = $config['eye_report'];
            if (is_array($config)) {
                $templateBasePath = static::normalizeDirPath($config['template_base_path']);
                if (isset($config['template_suffix'])) {
                    $templateSuffix = ltrim((string)$config['template_suffix'], '.');
                    if (!empty($templateSuffix)) {
                        $templateSuffix = '.' . $templateSuffix;
                    }
                }
                if (isset($config['templates']) && is_array($map)) {
                    $map = $config['templates'];
                }
                if (isset($config['default_template_layout'])) {
                    $templateLayout = static::normalizeViewPath(
                        $config['default_template_layout'], $templateBasePath, $templateSuffix
                    );
                    $viewTemplateMapResolver->add(TemplateManager::DEFAULT_LAYOUT_KEY, $templateLayout);
                }
            }
        }

        foreach ($map as $tk => $tv) {
            if (empty($tk) || !is_array($tv)
                || !isset($tv['pages']) || !is_array($tv['pages']) || empty($tv['pages'])
            ) {
                unset($map[$tk]);
                continue;
            }
            if (!preg_match('[a-zA-Z][a-zA-Z_]*', $tk)) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid template %s; must be a string containing only letters and underscores, and starting with a letter',
                    $tk
                ));
            }
            if (!isset($tv['name']) || !isset($tv['description'])) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid template %s; must have a name and a description', $tk
                ));
            }
            $pages = array_values($tv['pages']);
            $pageViews = array();
            $viewBase = TemplateManager::VIEW_KEY_BASE . $tk . '/';
            foreach ($pages as $pageNum => $page) {
                $pageView = $viewBase . 'page' . ($pageNum + 1);
                $pageViews[] = $pageView;
                $viewTemplateMapResolver->add($pageView,
                    static::normalizeViewPath($page, $templateBasePath, $templateSuffix)
                );
            }
            $map[$tk]['pages'] = $pageViews;
            if (isset($tv['layout'])) {
                $layoutView = $viewBase . 'layout';
                $viewTemplateMapResolver->add($layoutView,
                    static::normalizeViewPath($tv['layout'], $templateBasePath, $templateSuffix)
                );
                $map[$tk]['layout'] = $layoutView;
            }
        }
        if ($viewTemplateMapResolver->has(TemplateManager::DEFAULT_LAYOUT_KEY)) {
            foreach ($map as $tk => $tv) {
                if (!isset($tv['layout'])) {
                    $map[$tk]['layout'] = TemplateManager::DEFAULT_LAYOUT_KEY;
                }
            }
        }

        return new TemplateManager($map);
    }

    /**
     * Normalize a path
     *
     * @param  string $path
     * @return string
     */
    private static function normalizePath($path)
    {
        if (empty($path)) {
            return '';
        }
        $path = (string)$path;
        $path = str_replace('/', DIRECTORY_SEPARATOR, $path);
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
        $path = rtrim($path, DIRECTORY_SEPARATOR);
        return empty($path) ? DIRECTORY_SEPARATOR : $path;
    }

    /**
     * Normalize a path to a directory
     *
     * @param  string $path
     * @return string
     */
    private static function normalizeDirPath($path)
    {
        $path = static::normalizePath($path);
        if (empty($path)) {
            return '';
        }
        return substr($path, -1) == DIRECTORY_SEPARATOR ? $path : $path . DIRECTORY_SEPARATOR;
    }

    private static function normalizeViewPath($path, $base, $suffix) {
        $path = ltrim(static::normalizePath($path), DIRECTORY_SEPARATOR);
        return $base . rtrim($path, $suffix) . $suffix;
    }
}
