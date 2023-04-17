<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Projects extends Table
{
    protected $table = "projects";
    #[Properties(type: 'int', length: 11)]
    private int $id;
    #[Properties(type: 'int', length: 11)]
    private int $img_id;
    #[Properties(type: 'int', length: 11)]
    private int $page_id;
    #[Properties(type: 'int', length: 11)]
    private int $category_id;

    /**
     * Get the value of page_id
     */
    public function getPage_id()
    {
        return $this->page_id;
    }

    /**
     * Set the value of page_id
     *
     * @return  self
     */
    public function setPage_id($page_id)
    {
        $this->page_id = $page_id;

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

    /**
     * Get the value of category_id
     */
    public function getCategory_id()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @return  self
     */
    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function flush()
    {
        if (isset($this->id)) {
            parent::update(['img_id', 'page_id', 'category_id'], "id", [$this->img_id, $this->page_id, $this->category_id, $this->id]);
        } else {
            parent::insert(['img_id', 'page_id', 'category_id'], [$this->img_id, $this->page_id, $this->category_id]);
        }
    }

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
}
