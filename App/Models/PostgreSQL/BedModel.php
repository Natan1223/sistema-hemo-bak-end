<?php

namespace App\Models\PostgreSQL;

final class BedModel
{ 
    private $idBed;
    private $idCompany;
    private $description;
    private $active;


    /**
     * Get the value of idBed
     */ 
    public function getIdBed(): int
    {
        return $this->idBed;
    }

    /**
     * Set the value of idBed
     *
     * @return  self
     */ 
    public function setIdBed($idBed): BedModel
    {
        $this->idBed = $idBed;

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
    public function setIdCompany($idCompany): BedModel
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
    public function setDescription($description): BedModel
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
    public function setActive($active): BedModel
    {
        $this->active = $active;

        return $this;
    }
}