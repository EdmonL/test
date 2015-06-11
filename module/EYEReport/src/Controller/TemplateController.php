<?php
/**
 * TemplateController.php
 * Author: meng
 * Date: 09/06/2015
 * Time: 4:36 PM
 */

namespace EYEReport\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TemplateController extends AbstractActionController
{
    protected $tm;

    /**
     * @param \EYEReport\Template\TemplateManager $tm
     */
    public function __construct($tm)
    {
        $this->tm = $tm;
    }

    public function previewAction()
    {
        $template = $this->params()->fromRoute('template');
        $page = $this->params()->fromRoute('page');
        $view = new ViewModel();
        $this->tm->applyTemplateView($template, $page, $view, $this->layout());
        return $view;
    }
}