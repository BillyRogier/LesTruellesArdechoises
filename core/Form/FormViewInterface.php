<?php

namespace Core\Form;

interface FormViewInterface extends FormInterface
{
    /**
     * Retourne une input html
     */
    public function createAllInput();

    /**
     * Retourne le formulaire html
     */
    public function getView();
}
