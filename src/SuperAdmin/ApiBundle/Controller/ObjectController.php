<?php

namespace SuperAdmin\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of ObjectController
 *
 * @author cifren
 */
class ObjectController extends Controller
{

    public function saveAction(Request $request)
    {
        
        return new JsonResponse(array());
    }

}
