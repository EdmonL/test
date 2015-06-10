<?php
/**
 * TemplateManagerInterface.php
 * Author: meng
 * Date: 10/06/2015
 * Time: 2:49 PM
 */

namespace EYEReport\Template;


interface TemplateManagerInterface
{
    /**
     * @return Template
     */
    public function getTemplate($key);
}