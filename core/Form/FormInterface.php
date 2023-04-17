<?php

namespace Core\Form;

interface FormInterface
{
    /**
     * Créer une class FormBuilder est ajoute les informations au formulaire
     */
    public function createForm(string $action = "", string $method = "post", array $options = []): FormBuilder;

    /**
     * Retourne le formulaire sous html
     */
    public function createView(): string;

    /**
     * Retourne le formulaire
     */
    public function getForm(): FormInterface;

    /**
     * Renvoie boolean si les informations sont reçues
     */
    public function isSubmit(): bool;

    /**
     * Renvoie boolean si le formulaire est valid
     */
    public function isXmlValid($table = "");

    public function isValid($table = "");

    /**
     * Renvoie une array contenant les informations reçues
     */
    public function getData(): array;
}
