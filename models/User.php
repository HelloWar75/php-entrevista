<?php

class User
{
    private $id;
    private $name;
    private $email;
    private $colors;

    public function __construct($name, $email, $id = null, $colors = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->colors = $colors;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return Color[]
     */
    public function getColors() : array
    {
        return $this->colors;
    }

    public function setColors($colors)
    {
        $this->colors = $colors;
    }
}

