<?php

namespace ApiBundle\Model;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolation;

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
     * @return ConstraintViolationList
     */
    function getValidatorErrors()
    {
        return $this->validatorErrors;
    }

    function getAryValidatorErrors()
    {
        $validators = [];

        foreach ($this->validatorErrors as $errors) {
            $e['message'] = $errors->getMessage();
            $e['propertyPath'] = $errors->getPropertyPath();
            $e['class'] = get_class($errors->getRoot());
            $validators[] = $e;
        }

        return $validators;
    }

    function setValidatorErrors(ConstraintViolationList $validatorErrors)
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
