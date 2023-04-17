<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Contents extends Table
{
    protected $table = "contents";
    #[Properties(type: 'int', length: 11)]
    private int $id;
    #[Properties(type: 'string', length: 255)]
    private string $subtitle;
    #[Properties(type: 'id', length: 11)]
    private int $img_id;
    #[Properties(type: 'string')]
    private string $text;
    #[Properties(type: 'int', length: 11)]
    private int $page_id;

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     *
     * @return  self
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get the value of text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
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
            parent::update(['subtitle', 'img_id', 'text', 'page_id'], "id", [$this->subtitle, $this->img_id, $this->text, $this->page_id, $this->id]);
        } else {
            parent::insert(['subtitle', 'img_id', 'text', 'page_id'], [$this->subtitle, $this->img_id, $this->text, $this->page_id]);
        }
    }
}
