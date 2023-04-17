<?php

namespace Core\Form\Type;

class NumberType extends Type
{
    public function isValid($value)
    {
        if (!preg_match('/^[0-9]/', $value)) {
            return false;
        }
        return true;
    }

    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'text', $options, $options_html);
    }
}
