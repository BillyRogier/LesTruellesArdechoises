<?php

namespace Core\Table;

use Attribute;

#[Attribute]
class Properties
{
    function __construct(
        public ?string $type = null,
        public ?int $length = null,
    ) {
        $this->type = $type;
        $this->length = $length;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of length
     */
    public function getLenght()
    {
        return $this->length;
    }

    /**
     * Set the value of length
     *
     * @return  self
     */
    public function setLength($length)
    {
        $this->length = $length;

        return $this;
    }
}
