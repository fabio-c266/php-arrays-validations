<?php

namespace src\core;

use Exception;

class Validations
{
    protected $data = null;
    protected $param = null;

    public function string()
    {
        if (gettype($this->data) !== 'string') {
            throw new Exception(ErrorsMessages::INVALID_STRING);
        }
    }

    public function required()
    {
        if (!isset($this->data)) {
            throw new Exception(ErrorsMessages::REQUIRED);
        }
    }

    public function optional()
    {
        //ONLY TO DESCLARE
    }

    public function minLen()
    {
        if (gettype($this->data) === 'string') {
            if (strlen($this->data) < $this->param) {
                throw new Exception(str_replace('{number}', $this->param,  ErrorsMessages::MIN_LENGTH_ERROR));
            }
        }
    }

    public function maxLen()
    {
        if (gettype($this->data) === 'string') {
            if (strlen($this->data) > $this->param) {
                throw new Exception(str_replace('{number}', $this->param,  ErrorsMessages::MAX_LENGTH_ERROR));
            }
        }
    }

    /** MANIPULE CLASS ATRIBUTES */

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setParam($param)
    {
        $this->param = $param;
    }

    public function getData()
    {
        return $this->data;
    }
}
