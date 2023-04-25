<?php

namespace App\Table;

use Core\Table\Table;
use Core\Table\Properties;

class Info extends Table
{
    protected $table = "info";
    #[Properties(type: 'int', length: 1)]
    private int $id;
    #[Properties(type: 'string', length: 50000)]
    private $location = null;
    #[Properties(type: 'string', length: 255)]
    private $email = null;
    #[Properties(type: 'string', length: 15)]
    private $num = null;
    #[Properties(type: 'string', length: 50000)]
    private $facebook = null;
    #[Properties(type: 'string', length: 50000)]
    private $instagram = null;
    #[Properties(type: 'string', length: 50000)]
    private $etp_name = null;
    #[Properties(type: 'string', length: 255)]
    private $first_name = null;
    #[Properties(type: 'string', length: 255)]
    private $last_name = null;
    #[Properties(type: 'string', length: 255)]
    private $statut = null;
    #[Properties(type: 'int', length: 15)]
    private $immatriculation_number = null;
    #[Properties(type: 'string', length: 255)]
    private $host_name = null;
    #[Properties(type: 'string', length: 50000)]
    private $host_location = null;
    #[Properties(type: 'string', length: 20)]
    private $host_number = null;

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
     * Get the value of location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set the value of location
     *
     * @return  self
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of num
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set the value of num
     *
     * @return  self
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get the value of facebook
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set the value of facebook
     *
     * @return  self
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get the value of instagram
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * Set the value of instagram
     *
     * @return  self
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;

        return $this;
    }

    /**
     * Get the value of etp_name
     */
    public function getEtp_name()
    {
        return $this->etp_name;
    }

    /**
     * Set the value of etp_name
     *
     * @return  self
     */
    public function setEtp_name($etp_name)
    {
        $this->etp_name = $etp_name;

        return $this;
    }

    /**
     * Get the value of first_name
     */
    public function getFirst_name()
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */
    public function setFirst_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */
    public function getLast_name()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */
    public function setLast_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of statut
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set the value of statut
     *
     * @return  self
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get the value of immatriculation_number
     */
    public function getImmatriculation_number()
    {
        return $this->immatriculation_number;
    }

    /**
     * Set the value of immatriculation_number
     *
     * @return  self
     */
    public function setImmatriculation_number($immatriculation_number)
    {
        $this->immatriculation_number = $immatriculation_number;

        return $this;
    }

    /**
     * Get the value of host_name
     */
    public function getHost_name()
    {
        return $this->host_name;
    }

    /**
     * Set the value of host_name
     *
     * @return  self
     */
    public function setHost_name($host_name)
    {
        $this->host_name = $host_name;

        return $this;
    }

    /**
     * Get the value of host_location
     */
    public function getHost_location()
    {
        return $this->host_location;
    }

    /**
     * Set the value of host_location
     *
     * @return  self
     */
    public function setHost_location($host_location)
    {
        $this->host_location = $host_location;

        return $this;
    }

    /**
     * Get the value of host_number
     */
    public function getHost_number()
    {
        return $this->host_number;
    }

    /**
     * Set the value of host_number
     *
     * @return  self
     */
    public function setHost_number($host_number)
    {
        $this->host_number = $host_number;

        return $this;
    }

    public function flush()
    {
        if (isset($this->id)) {
            parent::update(['location', 'email', 'num', 'facebook', 'instagram', 'etp_name', 'first_name', 'last_name', 'statut', 'immatriculation_number', 'host_name', 'host_location', 'host_number'], "id", [$this->location, $this->email, $this->num, $this->facebook, $this->instagram, $this->etp_name, $this->first_name, $this->last_name, $this->statut, $this->immatriculation_number, $this->host_name, $this->host_location, $this->host_number, $this->id]);
        } else {
            parent::insert(['location', 'email', 'num', 'facebook', 'instagram', 'etp_name', 'first_name', 'last_name', 'statut', 'immatriculation_number', 'host_name', 'host_location', 'host_number'], [$this->location, $this->email, $this->num, $this->facebook, $this->instagram, $this->etp_name, $this->first_name, $this->last_name, $this->statut, $this->immatriculation_number, $this->host_name, $this->host_location, $this->host_number]);
        }
    }
}
