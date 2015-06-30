<?php

namespace SuperAdmin\InterfaceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of ObjectController
 *
 * @author cifren
 */
class ObjectController extends Controller
{

    public function defaultAction()
    {
        return $this->render('SuperAdminInterfaceBundle:Object:default.html.twig');
    }

    public function editAction()
    {
        return $this->render('SuperAdminInterfaceBundle:Object:edit.html.twig');
    }

    public function listAction()
    {
        return $this->render('SuperAdminInterfaceBundle:Object:list.html.twig');
    }

}
