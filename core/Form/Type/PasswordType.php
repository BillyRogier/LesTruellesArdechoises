<?php

namespace Core\Form\Type;

class PasswordType extends Type
{
    public function isValid($value)
    {
        if (7 > strlen($value)) { //check if string meets 8 or more characters
            return false;
        }
        if (strcspn($value, '0123456789') == strlen($value)) { //check if string has numbers
            return false;
        }
        if (strcspn($value, 'abcdefghijklmnopqrstuvwxyz') == strlen($value)) { //check if string has small letters
            return false;
        }
        if (strcspn($value, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ') == strlen($value)) { //check if string has capital letters
            return false;
        }
        if (strcspn($value, '{}[]|()_\/?§!$£') == strlen($value)) {
            return false;
        }
        return true;
    }

    public function getType()
    {
        return 'password';
    }

    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'password', $options, $options_html);
    }
}
