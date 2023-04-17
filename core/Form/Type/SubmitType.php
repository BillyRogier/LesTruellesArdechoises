<?php

namespace Core\Form\Type;

class SubmitType extends Type
{
    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'submit', $options, $options_html);
    }
}
