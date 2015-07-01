<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of CommonController
 *
 * @author cifren
 */
class CommonController extends Controller
{

    /**
     * Will get template asked for
     *
     * Example:
     *  When character "/"
     *      arg in js encodeURIComponent('EarlsLionBiBundle:Admin/Report:report_details.html.twig')
     * 
     * @param string $templateName
     * @return mixed
     */
    public function templateAccessAction($templateName)
    {
        $decodedName = urldecode($templateName);
        
        return $this->render($decodedName);
    }

}
