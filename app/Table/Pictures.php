<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Pictures extends Table
{
    protected $table = "pictures";
    #[Properties(type: 'int', length: 11)]
    private int $img_id;
    #[Properties(type: 'string', length: 255)]
    private string $src;
    #[Properties(type: 'string', length: 255)]
    private string $alt;

    /**
     * Get the value of src
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set the value of src
     *
     * @return  self
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get the value of alt
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set the value of alt
     *
     * @return  self
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get the value of img_id
     */
    public function getImg_id()
    {
        return $this->img_id;
    }

    /**
     * Set the value of img_id
     *
     * @return  self
     */
    public function setImg_id($img_id)
    {
        $this->img_id = $img_id;

        return $this;
    }

    public function flush()
    {
        if (isset($this->img_id)) {
            parent::update(['src', 'alt'], "img_id", [$this->src, $this->alt, $this->img_id]);
        } else {
            parent::insert(['src', 'alt'], [$this->src, $this->alt]);
        }
    }
}
