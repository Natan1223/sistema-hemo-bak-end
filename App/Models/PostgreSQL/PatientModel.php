<?php

namespace App\Models\PostgreSQL;

final class PatientModel
{ 
    private $idPatient;
    private $idPerson;
    private $prontuario;
    private $dateTimeRegister;
    private $active;


    /**
     * Get the value of idPatient
     */ 
    public function getIdPatient(): int
    {
        return $this->idPatient;
    }

    /**
     * Set the value of idPatient
     *
     * @return  self
     */ 
    public function setIdPatient($idPatient): PatientModel
    {
        $this->idPatient = $idPatient;

        return $this;
    }

    /**
     * Get the value of idPerson
     */ 
    public function getIdPerson(): int
    {
        return $this->idPerson;
    }

    /**
     * Set the value of idPerson
     *
     * @return  self
     */ 
    public function setIdPerson($idPerson): PatientModel
    {
        $this->idPerson = $idPerson;

        return $this;
    }

    /**
     * Get the value of prontuario
     */ 
    public function getProntuario(): string
    {
        return $this->prontuario;
    }

    /**
     * Set the value of prontuario
     *
     * @return  self
     */ 
    public function setProntuario($prontuario): PatientModel
    {
        $this->prontuario = $prontuario;

        return $this;
    }

    /**
     * Get the value of dateTimeRegister
     */ 
    public function getDateTimeRegister(): string
    {
        return $this->dateTimeRegister;
    }

    /**
     * Set the value of dateTimeRegister
     *
     * @return  self
     */ 
    public function setDateTimeRegister($dateTimeRegister): PatientModel
    {
        $this->dateTimeRegister = $dateTimeRegister;

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
    public function setActive($active): PatientModel
    {
        $this->active = $active;

        return $this;
    }
}