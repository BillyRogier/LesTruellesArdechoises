<?php

namespace Core\Form\Type;

class EmailType extends Type
{
    public function isValid($value)
    {
        if (!preg_match("/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i", $value)) {
            return false;
        }
        return true;
    }

    public function getMessage()
    {
        return "Veuillez rentrer un email valide";
    }

    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'email', $options, $options_html);
    }
}
