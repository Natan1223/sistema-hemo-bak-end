<?php

namespace App\Models\PostgreSQL;

final class HealthInsuranceModel
{ 
    private $idHealthInsurance;
    private $description;
    private $active;


    /**
     * Get the value of idHealthInsurance
     */ 
    public function getIdHealthInsurance()
    {
        return $this->idHealthInsurance;
    }

    /**
     * Set the value of idHealthInsurance
     *
     * @return  self
     */ 
    public function setIdHealthInsurance($idHealthInsurance)
    {
        $this->idHealthInsurance = $idHealthInsurance;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }
}