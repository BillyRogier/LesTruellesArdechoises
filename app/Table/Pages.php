<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Pages extends Table
{
    protected $table = "pages";
    #[Properties(type: 'int', length: 11)]
    private int $page_id;
    #[Properties(type: 'string', length: 255)]
    private string $name;
    #[Properties(type: 'string', length: 255)]
    private string $title;
    #[Properties(type: 'string', length: 255)]
    private string $url;

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
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

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

    public function flush()
    {
        if (isset($this->page_id)) {
            parent::update(['name', 'title', 'url'], "page_id", [$this->name, $this->title,  $this->url, $this->page_id]);
        } else {
            parent::insert(['name', 'title', 'url'], [$this->name, $this->title,  $this->url]);
        }
    }

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
}
