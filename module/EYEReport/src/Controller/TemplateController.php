<?php
/**
 * TemplateController.php
 * Author: meng
 * Date: 09/06/2015
 * Time: 4:36 PM
 */

namespace EYEReport\Controller;

use Zend\View\Model\ViewModel;

class TemplateController extends \Zend\Mvc\Controller\AbstractActionController
{
    public function previewAction()
    {
        $view = new ViewModel();
    }
}