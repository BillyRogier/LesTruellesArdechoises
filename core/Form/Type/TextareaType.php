<?php

namespace Core\Form\Type;

class TextareaType extends Type
{
    public function getTag($name, $options = "", $options_html = "", $value = "")
    {
        return parent::textarea($name, $value, $options);
    }
}
