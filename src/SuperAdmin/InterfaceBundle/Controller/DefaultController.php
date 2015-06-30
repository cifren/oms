<?php

namespace SuperAdmin\InterfaceBundle\Controller;

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
        return $this->render('SuperAdminInterfaceBundle:Default:index.html.twig');
    }

}
