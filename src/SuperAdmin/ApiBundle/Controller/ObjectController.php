<?php

namespace SuperAdmin\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $handler = new ObjectHandler($request, $this->get('validator'), $this->getDoctrine()->getManager());
        $handler->process();
        $jsonRequest = $handler->getJsonResponse();

        return $jsonRequest->getJsonResponse();
    }

    public function deleteAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $id = json_decode($request->getContent(), true)['id'];
        $object = $manager->getRepository('SuperAdmin\CoreBundle\Entity\Object')->find($id);
        $manager->remove($object);
        $manager->flush();
        return new JsonResponse(array('valid'));
    }

}
