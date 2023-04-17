<?php

namespace Core;

class Config
{
    private $settings = [];
    private static $_instance;

    public static function getInstance($file)
    {
        if (is_null(static::$_instance)) {
            static::$_instance = new Config($file);
        }
        return static::$_instance;
    }

    public function __construct($file)
    {
        $this->settings = require($file);
    }

    public function get($key)
    {
        if (!isset($this->settings[$key])) {
            return null;
        }
        return $this->settings[$key];
    }
}
