<?php

namespace Site\InterfaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of DefaultController
 *
 * @author cifren
 */
class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('SiteInterfaceBundle:Default:index.html.twig');
    }

}
