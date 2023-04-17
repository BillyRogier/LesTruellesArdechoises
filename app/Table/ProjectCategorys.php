<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class ProjectCategorys extends Table
{
    protected $table = "project_categorys";
    #[Properties(type: 'int', length: 11)]
    private int $id;
    #[Properties(type: 'string', length: 255)]
    private string $name;
    #[Properties(type: 'int', length: 11)]
    private int $img_id;
    #[Properties(type: 'string', length: 255)]
    private string $url;

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
    /**
     * Get the value of url
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of url
     *
     * @return  self
     */
    public function setUrl($url)
    {
        $this->url = $url;

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
            parent::update(['name', 'img_id', 'url'], "id", [$this->name, $this->img_id, $this->url, $this->id]);
        } else {
            parent::insert(['name', 'img_id', 'url'], [$this->name, $this->img_id, $this->url]);
        }
    }
}
