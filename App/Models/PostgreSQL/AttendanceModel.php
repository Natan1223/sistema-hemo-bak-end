<?php

namespace App\Models\PostgreSQL;

final class AttendanceModel
{ 
    private $idAttendance;
    private $idCompany;
    private $idPatient;
    private $idTypeAttendance;
    private $dateAttendance;
    private $dateClosing;


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
    public function setIdAttendance($idAttendance): AttendanceModel
    {
        $this->idAttendance = $idAttendance;

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
    public function setIdCompany($idCompany): AttendanceModel
    {
        $this->idCompany = $idCompany;

        return $this;
    }

    /**
     * Get the value of idPatient
     */ 
    public function getIdPatient()
    {
        return $this->idPatient;
    }

    /**
     * Set the value of idPatient
     *
     * @return  self
     */ 
    public function setIdPatient($idPatient): AttendanceModel
    {
        $this->idPatient = $idPatient;

        return $this;
    }

        /**
     * Get the value of idTypeAttendance
     */ 
    public function getIdTypeAttendance(): int
    {
        return $this->idTypeAttendance;
    }

    /**
     * Set the value of idTypeAttendance
     *
     * @return  self
     */ 
    public function setIdTypeAttendance($idTypeAttendance): AttendanceModel
    {
        $this->idTypeAttendance = $idTypeAttendance;

        return $this;
    }

    /**
     * Get the value of dateAttendance
     */ 
    public function getDateAttendance(): string
    {
        return $this->dateAttendance;
    }

    /**
     * Set the value of dateAttendance
     *
     * @return  self
     */ 
    public function setDateAttendance($dateAttendance): AttendanceModel
    {
        $this->dateAttendance = $dateAttendance;

        return $this;
    }

    /**
     * Get the value of dateClosing
     */ 
    public function getDateClosing(): string
    {
        return $this->dateClosing;
    }

    /**
     * Set the value of dateClosing
     *
     * @return  self
     */ 
    public function setDateClosing($dateClosing): AttendanceModel
    {
        $this->dateClosing = $dateClosing;

        return $this;
    }

}