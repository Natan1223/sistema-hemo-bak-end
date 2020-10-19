<?php

namespace App\Models\PostgreSQL;

final class ProcedureModel
{ 
    private $idProcedure;
    private $idAttendance;
    private $idTypeProcedure;
    private $observation;
    private $dateSolicitation;


    /**
     * Get the value of idProcedure
     */ 
    public function getIdProcedure(): int
    {
        return $this->idProcedure;
    }

    /**
     * Set the value of idProcedure
     *
     * @return  self
     */ 
    public function setIdProcedure($idProcedure): ProcedureModel
    {
        $this->idProcedure = $idProcedure;

        return $this;
    }

    /**
     * Get the value of idAttendance
     */ 
    public function getIdAttendance(): int
    {
        return $this->idAttendance;
    }

    /**
     * Set the value of idAttendance
     *
     * @return  self
     */ 
    public function setIdAttendance($idAttendance): ProcedureModel
    {
        $this->idAttendance = $idAttendance;

        return $this;
    }

    /**
     * Get the value of idTypeProcedure
     */ 
    public function getIdTypeProcedure(): int
    {
        return $this->idTypeProcedure;
    }

    /**
     * Set the value of idTypeProcedure
     *
     * @return  self
     */ 
    public function setIdTypeProcedure($idTypeProcedure): ProcedureModel
    {
        $this->idTypeProcedure = $idTypeProcedure;

        return $this;
    }

    /**
     * Get the value of observation
     */ 
    public function getObservation(): string
    {
        return $this->observation;
    }

    /**
     * Set the value of observation
     *
     * @return  self
     */ 
    public function setObservation($observation): ProcedureModel
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get the value of dateSolicitation
     */ 
    public function getDateSolicitation(): string
    {
        return $this->dateSolicitation;
    }

    /**
     * Set the value of dateSolicitation
     *
     * @return  self
     */ 
    public function setDateSolicitation($dateSolicitation): ProcedureModel
    {
        $this->dateSolicitation = $dateSolicitation;

        return $this;
    }

}