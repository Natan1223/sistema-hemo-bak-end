<?php

namespace App\Models\PostgreSQL;

final class OccupationModel
{
	private $idOccupation;
    private $cboRegistrationNumber;
    private $description;
    private $active;

    public function getIdOccupation(): int {
		return $this->IdOccupation;
	}

	/**
     * @return self
     */

	public function setIdOccupation(int $idOccupation): self {
		$this->idOccupation = $idOccupation;
        return $this;
	}

    
    public function getCboResgistrationNumber(): string {
        return $this->cboRegistrationNumber;
	}
    
	/**
     * @return self 
     */
    
    public function setCboRegistrationNumber(string $cboRegistrationNumber): self{
        $this->cboRegistrationNumber = $cboRegistrationNumber;
        return $this;
    }
    
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @return self
     */

    public function setDescription(string $description): self{
        $this->description = $description;
        return $this;
    }

    public function getActive(): string {
        return $this->active;
	}
    
	/**
     * @return self 
     */
    
    public function setActive(string $active): self{
		$this->active = $active;
        return $this;
	}

	
}