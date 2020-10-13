<?php

namespace App\Models\PostgreSQL;

final class ClinicModel
{ 
    private $idClinic;
    private $idCompany;
    private $description;
    private $active;

    

    /**
     * Get the value of idClinic
     */ 
    public function getIdClinic(): int
    {
        return $this->idClinic;
    }

    /**
     * Set the value of idClinic
     *
     * @return  self
     */ 
    public function setIdClinic($idClinic): ClinicModel
    {
        $this->idClinic = $idClinic;

        return $this;
    }

    /**
     * Get the value of idCompany
     */ 
    public function getIdCompany(): int
    {
        return $this->idCompany;
    }

    /**
     * Set the value of idCompany
     *
     * @return  self
     */ 
    public function setIdCompany($idCompany): ClinicModel
    {
        $this->idCompany = $idCompany;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description): ClinicModel
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of active
     */ 
    public function getActive(): string
    {
        return $this->active;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */ 
    public function setActive($active): ClinicModel
    {
        $this->active = $active;

        return $this;
    }
}