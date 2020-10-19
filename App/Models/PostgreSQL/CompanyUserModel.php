<?php

namespace App\Models\PostgreSQL;

class CompanyUserModel
{
	public $idUser;
	public $idCompany;
	public $idProfile;
	public $active;

	public function getIdUser(): int {
		return $this->idUser;
	}

	/**
     * @return self
     */

	public function setIdUser(int $idUser): self {
		$this->idUser = $idUser;
        return $this;
	}

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

	public function getIdProfile(): int {
		return $this->idProfile;
	}

	/**
     * @return self
     */

	public function setIdProfile(int $idProfile): self {
		$this->idProfile = $idProfile;
        return $this;
	}

	public function getActive(): string {
		return $this->active;
	}

	/**
     * @return self
     */

	public function setActive(string $active): self {
		$this->active = $active;
        return $this;
	}

}