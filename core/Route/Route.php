<?php

namespace Core\Route;

use App;
use Attribute;

#[Attribute]
class Route
{
    public ?string $path;
    public ?string $name;

    public function __construct($path = null, $name = null)
    {
        $this->path = $path;
        $this->name = $name;
    }
    /**
     * Get the value of path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
