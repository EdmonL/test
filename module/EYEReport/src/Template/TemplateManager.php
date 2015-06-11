<?php
/**
 * TemplateManager.php
 * Author: meng
 * Date: 10/06/2015
 * Time: 2:48 PM
 */

namespace EYEReport\Template;


class TemplateManager
{
    const VIEW_KEY_BASE = 'eye_report/template/';
    const DEFAULT_LAYOUT_KEY = 'eye_report/template/layout';

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param string $template
     * @return array
     */
    public function getTemplateConfig($template)
    {
        return $this->config[$template];
    }

    /**
     * @param string $template
     * @param integer $pageNum starts from 1
     * @param \Zend\Mvc\Controller\Plugin\Layout|\Zend\View\Model\ModelInterface $layout
     * @param \Zend\View\Model\ViewModel $view
     * @return TemplateManager
     */
    public function applyTemplateView($template, $pageNum, $view, $layout)
    {
        $tc = $this->config[$template];
        if (!isset($tc)) {
            throw new \InvalidArgumentException('Invalid template ' . $template);
        }
        $pages = $tc['pages'];
        if (!is_int($pageNum) || $pageNum < 1 || $pageNum > count($pages)) {
            throw new \InvalidArgumentException('Invalid page number ' . $pageNum);
        }
        if (isset($tc['layout'])) {
            if (isset($layout)) {
                $layout->setTemplate($tc['layout']);
                $view->setTerminal(false);
            }
        } else {
            $view->setTerminal(true);
        }
        $view->setTemplate($pages[$pageNum - 1]);
        return $this;
    }
}