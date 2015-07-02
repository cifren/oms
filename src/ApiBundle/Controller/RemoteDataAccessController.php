<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiBundle\Model\Helper\SerializerHelper;

class RemoteDataAccessController extends Controller
{

    /**
     * entityName need to replace "\" by "-"
     * 
     * @return JsonResponse
     */
    public function getRepositoryJsonAction()
    {
        $entityName = str_replace('-', "\\", $this->getRequest()->get('entityName'));
        $functionName = $this->getRequest()->get('functionName');
        $parameters = $this->getRequest()->get('parameters');

        if ($entityName && $functionName) {
            $repo = $this->getDoctrine()->getManager()->getRepository($entityName);

            $parameters = $this->fillupArrayKey($parameters);
            $objectOrArray = call_user_func_array(array($repo, $functionName), is_array($parameters) ? $parameters : array());

            $serializerHelper = new SerializerHelper();

            if (is_array($objectOrArray)) {
                $data = array();
                foreach ($objectOrArray as $key => $item) {
                    $data[$key] = $serializerHelper->getArrayFromObject($item);
                }
            } else {
                $data = $serializerHelper->getArrayFromObject($objectOrArray);
            }

            return new JsonResponse($data);
        }

        return new JsonResponse(array());
    }

    /**
     * if key 1 exist, function will create index 0
     *
     * @param type $array
     */
    protected function fillupArrayKey($array)
    {
        if (empty($array)) {
            return $array;
        }
        //get only integer keys
        $keys = array_keys($array);

        foreach ($keys as $i => $key) {
            if ($key !== intval($key)) {
                unset($keys[$i]);
            }
        }
        $max = max($keys);

        for ($index = 0; $index <= $max; $index++) {
            $fillUpArray[$index] = !isset($array[$index]) ? array() : $array[$index];
        }

        return $fillUpArray;
    }

}
