<?php

namespace App\Models\PostgreSQL;

final class DiagnosisModel
{ 
    private $idDiagnosis;
    private $code;
    private $description;
    private $shortDescription;
    private $active;


    /**
     * Get the value of idDiagnosis
     */ 
    public function getIdDiagnosis(): int
    {
        return $this->idDiagnosis;
    }

    /**
     * Set the value of idDiagnosis
     *
     * @return  self
     */ 
    public function setIdDiagnosis($idDiagnosis): DiagnosisModel
    {
        $this->idDiagnosis = $idDiagnosis;

        return $this;
    }

    /**
     * Get the value of code
     */ 
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code): DiagnosisModel
    {
        $this->code = $code;

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
    public function setDescription($description): DiagnosisModel
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of shortDescription
     */ 
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * Set the value of shortDescription
     *
     * @return  self
     */ 
    public function setShortDescription($shortDescription): DiagnosisModel
    {
        $this->shortDescription = $shortDescription;

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
    public function setActive($active): DiagnosisModel
    {
        $this->active = $active;

        return $this;
    }
}