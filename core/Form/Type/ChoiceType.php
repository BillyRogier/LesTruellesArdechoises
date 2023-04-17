<?php

namespace Core\Form\Type;

class ChoiceType extends Type
{
    public function getTag($name, $options = [], $options_choice = [])
    {
        $options_container = "";
        if (isset($options_choice['choices'])) {
            foreach ($options_choice['choices'] as $name_choice => $value) {
                if (isset($options_choice['value'])) {
                    if ($value == $options_choice['value']) {
                        $options_container .= parent::options($name_choice, $value, true);
                        continue;
                    }
                }
                $options_container .= parent::options($name_choice, $value);
            }
        }
        return parent::select($name, $options, $options_container);
    }
}
