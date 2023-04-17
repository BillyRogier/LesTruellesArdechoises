<?php

namespace Core\Error;

class Error
{
    private $error = [];

    public function danger($message, $name)
    {
        $this->error[$name] = ["<li class='danger'>$message</li>"];
        return $this;
    }

    public function alert($message, $name)
    {
        $this->error[$name] = ["<li class='alert'>$message</li>"];
        return $this;
    }

    public function success($message)
    {
        return "<li class='success'>$message</li>";
    }

    public function location($message, $name)
    {
        $this->error[$name] = [$message];
        return $this;
    }

    public function toJson($array)
    {
        foreach ($array as $name => $propertie) {
            foreach ($propertie as $cle => $value) {
                $this->error[$name][$cle] = $value;
            }
        }
        return $this;
    }

    public function getErrorMessage()
    {
        return $this->error;
    }

    public function setError($error)
    {
        $this->error = $error;
        return $this->error;
    }

    public function getView()
    {
        return json_encode($this->error);
    }

    public function noError()
    {
        if (empty($this->error)) {
            return true;
        }
        return false;
    }

    public function getXmlMessage($properties)
    {
        echo json_encode(["properties" => $properties, 'error_container' => isset($this->error['error_container']) ? $this->error['error_container'] : "", 'success_location' => isset($this->error['success_location']) ? $this->error['success_location'] : ""]);
        exit;
    }
}
