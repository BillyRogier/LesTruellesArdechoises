<?php

namespace Core\Response;

class Response
{
    private $path;
    private $templates;
    private $renderArray;

    /**
     * Get the value of renderArray
     */
    public function getRenderArray()
    {
        return $this->renderArray;
    }

    /**
     * Set the value of renderArray
     *
     * @return  self
     */
    public function setRenderArray($renderArray)
    {
        $this->renderArray = $renderArray;

        return $this;
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
     * Get the value of templates
     */
    public function getTemplates()
    {
        return $this->templates;
    }

    /**
     * Set the value of templates
     *
     * @return  self
     */
    public function setTemplates($templates)
    {
        $this->templates = $templates;

        return $this;
    }
}
