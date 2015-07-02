<?php

namespace ApiBundle\Model\Response;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of CustomJsonResponse
 *
 * @author cifren
 */
class ValidateJsonResponse
{

    const VALID = 1;
    const ERROR = 2;

    protected $status;
    protected $validatorErrors;
    protected $msg;
    protected $data;

    public function getStatus()
    {
        return $this->status;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setMsg($msg)
    {
        $this->msg = $msg;
        return $this;
    }

    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 
     * @return array of ConstraintViolationList
     */
    function getValidatorErrors()
    {
        return $this->validatorErrors;
    }

    function getAryValidatorErrors()
    {
        $validators = [];
        if (count($this->validatorErrors) > 0) {
            foreach ($this->validatorErrors as $key => $entityErrorList) {
                $entityValidator = [];
                foreach ($entityErrorList as $errors) {
                    $e['message'] = $errors->getMessage();
                    $e['propertyPath'] = $errors->getPropertyPath();
                    $e['class'] = get_class($errors->getRoot());
                    $entityValidator[] = $e;
                }
                if (count($entityValidator) > 0) {
                    $validators[$key] = $entityValidator;
                }
            }
        }

        return $validators;
    }

    function setValidatorErrors(array $validatorErrors)
    {
        $this->validatorErrors = $validatorErrors;
        return $this;
    }

    public function getArray()
    {
        return array(
            'status' => $this->getStatus(),
            'msg' => $this->getMsg(),
            'data' => $this->getData(),
            'validatorErrorList' => $this->getAryValidatorErrors()
        );
    }

    public function getJsonResponse()
    {
        return new JsonResponse($this->getArray());
    }

}
