<?php

namespace App\Models\PostgreSQL;

final class CompanyModel
{
	private $idCompany;
    private $name;
    private $telephone;
    private $active;

    public function getIdCompany(): int {
		return $this->idCompany;
	}

	/**
     * @return self
     */

	public function setIdCompany(int $idCompany): self {
		$this->idCompany = $idCompany;
        return $this;
	}

	public function getName(): string {
		return $this->name;
	}

	/**
     * @return self
     */

	public function setName(string $name): self{
		$this->name = $name;
        return $this;
    }
    
    public function getTelephone(): string {
		return $this->telephone;
	}

	/**
     * @return self 
     */

	public function setTelephone(string $telephone): self{
		$this->telephone = $telephone;
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