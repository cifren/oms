<?php

namespace SuperAdmin\ApiBundle\Validation\Handler;

use ApiBundle\Model\Response\ValidateJsonResponse;
use Symfony\Component\HttpFoundation\Request;
use SuperAdmin\CoreBundle\Entity\Object;
use SuperAdmin\CoreBundle\Entity\Field;
use Doctrine\ORM\EntityManager;

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
    protected $entityManager;

    public function __construct(Request $request, $validator, $em)
    {
        $this->entityManager = $em;
        $this->request = $request;
        $this->validator = $validator;
    }

    public function process()
    {
        $entity = $this->transformRequestIntoEntity($this->getRequest($this->parameterName));
        $validationErrorList = $this->validateEntities($entity);
        $this->save($validationErrorList, $entity);
        $this->setJsonResponse($validationErrorList, $entity);
    }

    protected function transformRequestIntoEntity(array $aryRequest)
    {
        $objectId = $this->getFromArray($aryRequest, 'id');

        if ($objectId) {
            $object = $this->getEntityManager()->getRepository('SuperAdmin\CoreBundle\Entity\Object')->find($objectId);
        } else {
            $object = new Object();
        }
        $object->setName($this->getFromArray($aryRequest, 'name'));
        $object->setDescription($this->getFromArray($aryRequest, 'description'));

        $aryFields = $this->getFromArray($aryRequest, 'fields');
        $fields = [];
        foreach ($aryFields as $value) {
            $fieldId = $this->getFromArray($value, 'id');
            if ($fieldId) {
                $field = $this->getEntityManager()->getRepository('SuperAdmin\CoreBundle\Entity\Field')->find($fieldId);
            } else {
                $field = new Field();
            }
            $field->setDefaultValue($this->getFromArray($value, 'defaultValue'));
            $field->setDescription($this->getFromArray($value, 'description'));
            $field->setLabel($this->getFromArray($value, 'label'));
            $field->setName($this->getFromArray($value, 'name'));
            $field->setPlaceholder($this->getFromArray($value, 'placeholder'));
            $required = $this->getFromArray($value, 'required', false);
            $field->setRequired($required == "1" ? true : false);
            $field->setType($this->getFromArray($value, 'type'));

            $fields[] = $field;
        }
        $object->setFields($fields);

        return $object;
    }

    protected function validateEntities(Object $object)
    {
        $errorListTemp = $this->validator->validate($object);
        if (count($errorListTemp) > 0) {
            $errorList['object'] = $this->validator->validate($object);
        }

        $fields = $object->getFields();
        $i = 0;
        foreach ($fields as $key => $field) {
            $errorListTemp = $this->validator->validate($field);
            if (count($errorListTemp) > 0) {
                $errorList['field' . $i] = $this->validator->validate($field);
            }
            $i++;
        }

        return isset($errorList) ? $errorList : [];
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

    protected function setJsonResponse(array $validationErrorList, Object $object)
    {
        $this->jsonResponse = new ValidateJsonResponse();
        $fieldIds = [];
        foreach ($object->getFields() as $field) {
            $fieldIds[]['id'] = $field->getId();
        }
        $this->jsonResponse->setData(array('id' => $object->getId(), 'fields' => $fieldIds));
        
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

    protected function save(array $validationErrorList, Object $object)
    {
        if (count($validationErrorList) === 0) {
            $this->getEntityManager()->persist($object);
            $this->getEntityManager()->flush();
        }
    }

    /**
     * 
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * 
     * @param EntityManager $entityManager
     * @return \SuperAdmin\ApiBundle\Validation\Handler\ObjectHandler
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}
