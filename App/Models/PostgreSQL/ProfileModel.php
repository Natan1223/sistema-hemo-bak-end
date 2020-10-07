<?php

namespace App\Models\PostgreSQL;

class ProfileModel
{
	public $idProfile;
	public $description;
	public $active;

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