<?php

namespace App\Models\PostgreSQL;

final class ClinicBedModel
{ 
    private $idClinic;
    private $idBed;

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
    public function setIdClinic($idClinic): ClinicBedModel
    {
        $this->idClinic = $idClinic;

        return $this;
    }

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
    public function setIdBed($idBed): ClinicBedModel
    {
        $this->idBed = $idBed;

        return $this;
    }
}