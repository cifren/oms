<?php

namespace SuperAdmin\ApiBundle\Validation\Handler;

use ApiBundle\Model\ValidateJsonResponse;
use Symfony\Component\HttpFoundation\Request;
use SuperAdmin\CoreBundle\Entity\Object;
use SuperAdmin\CoreBundle\Entity\Field;

/**
 * Description of ObjectHandler
 *
 * @author cifren
 */
class ObjectHandler
{

    protected $validator;
    protected $parameterName = "formObject";
    protected $request;
    protected $jsonResponse;

    public function __construct(Request $request, $validator)
    {
        $this->request = $request;
        $this->validator = $validator;
    }

    public function process()
    {
        $aryEntity = $this->transformRequestIntoEntity($this->getRequest($this->parameterName));
        $validationErrorList = $this->validateEntities($aryEntity);
        $this->setJsonResponse($validationErrorList);
    }

    protected function transformRequestIntoEntity(array $aryRequest)
    {
        $object = new Object();
        $object->setName($this->getFromArray($aryRequest, 'name'));
        $object->setDescription($this->getFromArray($aryRequest, 'description'));

        $aryFields = $this->getFromArray($aryRequest, 'fields');
        $fields = [];
        foreach ($aryFields as $value) {
            $field = new Field();
            $field->setDefaultValue($this->getFromArray($aryRequest, 'defaultValue'));
            $field->setDescription($this->getFromArray($aryRequest, 'description'));
            $field->setLabel($this->getFromArray($aryRequest, 'label'));
            $field->setPlaceholder($this->getFromArray($aryRequest, 'placeholder'));
            $field->setRequired($this->getFromArray($aryRequest, 'required'));
            $field->setType($this->getFromArray($aryRequest, 'type'));

            $fields[] = $field;
        }

        return $object;
    }

    protected function validateEntities(Object $object)
    {
        $errorList = $this->validator->validate($object);
        
        return $errorList;
    }

    protected function getFromArray($request, $field, $defaultValue = null)
    {
        if (isset($request[$field])) {
            return $request[$field];
        } else {
            return $defaultValue;
        }
    }

    protected function getRequest($paramName)
    {
        $params = array();
        if (!$this->request->query->get($paramName)) { //maybe means it is encoded in JSON
            $content = $this->request->getContent();
            if (!empty($content)) {
                $decodedParams = json_decode($content, true); // 2nd param to get as array
            }
            if (isset($decodedParams[$paramName])) {
                $params = $decodedParams[$paramName];
            }
        } else {
            $params = $this->request->query->get($paramName, array());
        }

        return $params;
    }

    /**
     * 
     * @return ValidateJsonResponse
     */
    public function getJsonResponse()
    {
        return $this->jsonResponse;
    }

    protected function setRequest($request)
    {
        $this->request = $request;
        return $this;
    }

    protected function setJsonResponse($validationErrorList)
    {
        $this->jsonResponse = new ValidateJsonResponse();
        if (count($validationErrorList) > 0) {
            $this->jsonResponse->setStatus(ValidateJsonResponse::ERROR);
            $this->jsonResponse->setMsg('Not Valid');
            $this->jsonResponse->setValidatorErrors($validationErrorList);
        } else {
            $this->jsonResponse->setStatus(ValidateJsonResponse::VALID);
            $this->jsonResponse->setMsg('Valid');
        }
        
        return $this;
    }

}
