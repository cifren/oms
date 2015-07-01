<?php

namespace ApiBundle\Model;

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

    function getValidatorErrors()
    {
        return $this->validatorErrors;
    }

    function setValidatorErrors($validatorErrors)
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
            'validatorErrorList' => $this->getValidatorErrors()
        );
    }

}
