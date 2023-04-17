<?php

namespace Core\Form\Type;

class HiddenType extends Type
{
    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'hidden', $options, $options_html);
    }
}
