<?php

namespace Core\Form;

use Core\Error\Error;
use Core\Form\Type\FileType;
use Core\Form\Type\SubmitType;

class Form implements FormInterface
{
    protected $form;

    public function createForm(string $action = "", string $method = "post", array $options = []): FormBuilder
    {
        $formBuilder = new FormBuilder($action, $method, $options);
        return $formBuilder;
    }

    public function createView(): string
    {
        $formView = new FormView($this->form);
        return $formView->getView();
    }

    public function getForm(): FormInterface
    {
        return $this;
    }

    public function isSubmit(): bool
    {
        $submit = false;
        if (isset($_POST) && !empty($_POST)) {
            $submit = true;
            // foreach ($this->form['input'] as $input) {
            //     if ($input[0]['type'] != SubmitType::class && $input[0]['type'] != FileType::class) {
            //         if (!isset($_POST[$input[0]['name']])) {
            //             $submit = false;
            //         }
            //     }
            // }
        }
        return $submit;
    }

    public function isXmlValid($table = "")
    {
        $error = new FormError($this->form, $table);
        return $error->getError(true);
    }

    public function isValid($table = "")
    {
        $error = new FormError($this->form, $table);
        return $error->getError(false);
    }

    public function getData(): array
    {
        $array = [];
        foreach ($_POST as $cle => $value) {
            if (is_array($value)) {
                $array[$cle] = $value;
            } else {
                $array[$cle] = htmlspecialchars($value);
            }
        }
        foreach ($_FILES as $cle => $value) {
            $array[$cle] = $value;
        }
        return $array;
    }
}
