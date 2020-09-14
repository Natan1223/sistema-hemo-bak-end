<?php

namespace App\Models\PostgreSQL;

final class CityModel
{
	private $idCity;
	private $description;

    public function getIdCity(): int {
		return $this->idCity;
	}

	/**
     * @return self
     */

	public function setIdCity(int $idCity): self {
		$this->idCity = $idCity;
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

	
}