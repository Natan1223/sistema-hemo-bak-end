<?php

namespace App\Models\PostgreSQL;

final class ProfessionalCouncilModel
{
	private $idProfessionalCouncil;
    private $description;
    private $initials;
    private $active;

    public function getIdProfessionalCouncil(): int {
		return $this->idProfessionalCouncil;
	}

	/**
     * @return self
     */

	public function setIdProfessionalCouncil(int $idProfessionalCouncil): self {
		$this->idProfessionalCouncil = $idProfessionalCouncil;
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
    
    public function getInitials(): string {
		return $this->initials;
	}

	/**
     * @return self 
     */

	public function setInitials(string $initials): self{
		$this->initials = $initials;
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