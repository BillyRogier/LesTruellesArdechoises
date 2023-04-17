<?php

namespace Core\Form;

interface FormErrorInterface extends FormInterface
{
    public function __construct($form, $table);

    /**
     * Retourne Un boolean si les informations sont correctes
     */
    public function getError(bool $xml);
}
