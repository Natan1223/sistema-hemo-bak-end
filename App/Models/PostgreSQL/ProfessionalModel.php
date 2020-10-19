<?php

namespace App\Models\PostgreSQL;

final class ProfessionalModel
{
    private $idProfessional;
    private $idPerson;
    private $idProfessionalCouncil;
    private $councilNumber;
    private $registry;
    private $active;

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

    public function getIdPerson(): int
    {
        return $this->idPerson;
    }

    /**
     * @return  self
     */ 

    public function setIdPerson($idPerson): self
    {
        $this->idPerson = $idPerson;

        return $this;
    }

    public function getIdProfessionalCouncil(): int
    {
        return $this->idProfessionalCouncil;
    }

    /**
     * @return  self
     */ 
    
    public function setIdProfessionalCouncil($idProfessionalCouncil): self
    {
        $this->idProfessionalCouncil = $idProfessionalCouncil;

        return $this;
    }

	public function getCouncilNumber(): string {
		return $this->councilNumber;
	}

	/**
     * @return self
     */

	public function setCouncilNumber(string $councilNumber): self{
		$this->councilNumber = $councilNumber;
        return $this;
    }
    
    public function getRegistry(): string {
		return $this->registry;
	}

	/**
     * @return self 
     */

	public function setRegistry(string $registry): self{
		$this->registry = $registry;
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