<?php

namespace SuperAdmin\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SuperAdmin\ApiBundle\Validation\Handler\ObjectHandler;

/**
 * Description of ObjectController
 *
 * @author cifren
 */
class ObjectController extends Controller
{

    public function saveAction(Request $request)
    {
        $handler = new ObjectHandler($request, $this->get('validator'));
        $handler->process();
        $jsonRequest = $handler->getJsonResponse();
        
        return $jsonRequest->getJsonResponse();
    }

}
