<?php

namespace Core\Form\Type;

class TextType extends Type
{
    public function getTag($name, $options, $options_html)
    {
        return parent::input($name, 'text', $options, $options_html);
    }
}
