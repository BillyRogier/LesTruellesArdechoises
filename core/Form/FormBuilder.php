<?php

namespace Core\Form;

class FormBuilder extends Form implements FormBuilderInterface
{
    public function __construct(string $action = "", string $method = "post", array $options = [])
    {
        $this->form = ['action' => $action, 'method' => $method, 'options' => $options];
    }

    public function add(string $name, string $type = "text", array $options = []): FormBuilderInterface
    {
        if (isset($this->form['input'][$name])) {
            array_push($this->form['input'][$name], ['name' => $name, 'type' => $type, 'options' => $options]);
        } else {
            $this->form['input'][$name] = [];
            array_push($this->form['input'][$name], ['name' => $name, 'type' => $type, 'options' => $options]);
        }
        return $this;
    }

    public function change(string $name, array $options = [], int $key = 0): FormBuilderInterface
    {
        $previousInput = $this->form['input'][$name][$key];
        $this->form['input'][$name][$key] = ['name' => $name, 'type' => $previousInput['type'],  'options' => $options];
        return $this;
    }
}
