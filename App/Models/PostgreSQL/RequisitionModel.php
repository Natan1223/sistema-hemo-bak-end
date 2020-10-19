<?php

namespace App\Models\PostgreSQL;

final class RequisitionModel
{ 
    private $idRequisition;
    private $idProcedure;
    private $idUser;
    private $idStatusRequisition;
    private $idTypeTransfusion;
    private $idCompany;
    private $idBad;
    private $idClinic;
    private $idProfessionalMedical;
    private $weight;
    private $platelets;
    private $hematoctro;
    private $hemoglobin;
    private $observation;
    private $dateTimeRegister;


    /**
     * Get the value of idRequisition
     */ 
    public function getIdRequisition(): int
    {
        return $this->idRequisition;
    }

    /**
     * Set the value of idRequisition
     *
     * @return  self
     */ 
    public function setIdRequisition($idRequisition): RequisitionModel
    {
        $this->idRequisition = $idRequisition;

        return $this;
    }

    /**
     * Get the value of idProcedure
     */ 
    public function getIdProcedure()
    {
        return $this->idProcedure;
    }

    /**
     * Set the value of idProcedure
     *
     * @return  self
     */ 
    public function setIdProcedure($idProcedure): RequisitionModel
    {
        $this->idProcedure = $idProcedure;

        return $this;
    }

    /**
     * Get the value of idUser
     */ 
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set the value of idUser
     *
     * @return  self
     */ 
    public function setIdUser($idUser): RequisitionModel
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get the value of idStatusRequisition
     */ 
    public function getIdStatusRequisition()
    {
        return $this->idStatusRequisition;
    }

    /**
     * Set the value of idStatusRequisition
     *
     * @return  self
     */ 
    public function setIdStatusRequisition($idStatusRequisition): RequisitionModel
    {
        $this->idStatusRequisition = $idStatusRequisition;

        return $this;
    }

    /**
     * Get the value of idTypeTransfusion
     */ 
    public function getIdTypeTransfusion()
    {
        return $this->idTypeTransfusion;
    }

    /**
     * Set the value of idTypeTransfusion
     *
     * @return  self
     */ 
    public function setIdTypeTransfusion($idTypeTransfusion): RequisitionModel
    {
        $this->idTypeTransfusion = $idTypeTransfusion;

        return $this;
    }

    /**
     * Get the value of idCompany
     */ 
    public function getIdCompany()
    {
        return $this->idCompany;
    }

    /**
     * Set the value of idCompany
     *
     * @return  self
     */ 
    public function setIdCompany($idCompany): RequisitionModel
    {
        $this->idCompany = $idCompany;

        return $this;
    }

    /**
     * Get the value of idBad
     */ 
    public function getIdBad()
    {
        return $this->idBad;
    }

    /**
     * Set the value of idBad
     *
     * @return  self
     */ 
    public function setIdBad($idBad): RequisitionModel
    {
        $this->idBad = $idBad;

        return $this;
    }

    /**
     * Get the value of idClinic
     */ 
    public function getIdClinic()
    {
        return $this->idClinic;
    }

    /**
     * Set the value of idClinic
     *
     * @return  self
     */ 
    public function setIdClinic($idClinic): RequisitionModel
    {
        $this->idClinic = $idClinic;

        return $this;
    }

    /**
     * Get the value of idProfessionalMedical
     */ 
    public function getIdProfessionalMedical()
    {
        return $this->idProfessionalMedical;
    }

    /**
     * Set the value of idProfessionalMedical
     *
     * @return  self
     */ 
    public function setIdProfessionalMedical($idProfessionalMedical): RequisitionModel
    {
        $this->idProfessionalMedical = $idProfessionalMedical;

        return $this;
    }

    /**
     * Get the value of weight
     */ 
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set the value of weight
     *
     * @return  self
     */ 
    public function setWeight($weight): RequisitionModel
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get the value of platelets
     */ 
    public function getPlatelets()
    {
        return $this->platelets;
    }

    /**
     * Set the value of platelets
     *
     * @return  self
     */ 
    public function setPlatelets($platelets): RequisitionModel
    {
        $this->platelets = $platelets;

        return $this;
    }

    /**
     * Get the value of hematoctro
     */ 
    public function getHematoctro()
    {
        return $this->hematoctro;
    }

    /**
     * Set the value of hematoctro
     *
     * @return  self
     */ 
    public function setHematoctro($hematoctro): RequisitionModel
    {
        $this->hematoctro = $hematoctro;

        return $this;
    }

    /**
     * Get the value of hemoglobin
     */ 
    public function getHemoglobin()
    {
        return $this->hemoglobin;
    }

    /**
     * Set the value of hemoglobin
     *
     * @return  self
     */ 
    public function setHemoglobin($hemoglobin): RequisitionModel
    {
        $this->hemoglobin = $hemoglobin;

        return $this;
    }

    /**
     * Get the value of observation
     */ 
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set the value of observation
     *
     * @return  self
     */ 
    public function setObservation($observation): RequisitionModel
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get the value of dateTimeRegister
     */ 
    public function getDateTimeRegister()
    {
        return $this->dateTimeRegister;
    }

    /**
     * Set the value of dateTimeRegister
     *
     * @return  self
     */ 
    public function setDateTimeRegister($dateTimeRegister): RequisitionModel
    {
        $this->dateTimeRegister = $dateTimeRegister;

        return $this;
    }
}