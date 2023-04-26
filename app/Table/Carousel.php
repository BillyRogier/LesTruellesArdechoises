<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Carousel extends Table
{
    protected $table = "carousel";
    #[Properties(type: 'int', length: 11)]
    private int $id;
    #[Properties(type: 'int', length: 11)]
    private int $img_id;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

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
        if (isset($this->id)) {
            parent::update(['img_id'], "id", [$this->img_id, $this->id]);
        } else {
            parent::insert(['img_id'], [$this->img_id]);
        }
    }
}
