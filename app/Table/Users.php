<?php

namespace App\Table;

use Core\Table\Properties;
use Core\Table\Table;

class Users extends Table
{
    protected $table = "users";
    private int $id;
    #[Properties(type: 'string', length: 255)]
    private string $email;
    #[Properties(type: 'string', length: 255)]
    private string $password;

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    public function flush()
    {
        if (isset($this->id)) {
            parent::update([$this->email, $this->password, $this->id]);
        } else {
            parent::insert(['email', 'password'], [$this->email, $this->password]);
        }
    }
}
