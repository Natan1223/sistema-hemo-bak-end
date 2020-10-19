<?php

namespace App\Models\PostgreSQL;

final class ProfessionalOccupationModel
{
    private $idProfessional;
    private $idOccupation;
    private $idCompany;

    public function getIdProfessional(): int {
		return $this->idProfessional;
	}

	/**
     * @return self
     */

	public function setIdProfessional(int $idProfessional): self {
		$this->idProfessional = $idProfessional;
        return $this;
    }

    public function getIdOccupation(): int
    {
        return $this->idOccupation;
    }

    /**
     * @return  self
     */ 

    public function setIdOccupation($idOccupation): self
    {
        $this->idOccupation = $idOccupation;

        return $this;
    }

    public function getIdCompany(): int
    {
        return $this->idCompany;
    }

    /**
     * @return  self
     */ 
    
    public function setIdCompany($idCompany): self
    {
        $this->idCompany = $idCompany;

        return $this;
    }
	
}