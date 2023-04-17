<?php

namespace Core\Form;

interface FormBuilderInterface extends FormInterface
{
    public function __construct(string $action = "", string $method = "post", array $options = []);

    /**
     * Ajoute une input avec les informations données
     */
    public function add(string $name, string $type = "text", array $options = []): FormBuilderInterface;

    /**
     * Change les informations de l'input ayant le nom renseigné
     */
    public function change(string $name, array $options = [], int $key = 0): FormBuilderInterface;
}
