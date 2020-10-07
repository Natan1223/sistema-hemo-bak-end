<?php

namespace App\Models\PostgreSQL;

class MenuModel
{
	public $idMenu;
	public $idProfile;
	public $description;
	public $idMenuTitle;
	public $active;
	public $path;

    public function getIdMenu(): int {
		return $this->idMenu;
	}

	/**
     * @return self
     */

	public function setIdMenu(int $idMenu): self {
		$this->idMenu = $idMenu;
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
    
    public function getIdMenuTitle(): int {
		return $this->idMenuTitle;
    }
    
	/**
     * @return self
     */

	public function setIdMenuTitle(int $idMenuTitle): self{
		$this->idMenuTitle = $idMenuTitle;
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
	
	public function getPath(): string {
		return $this->path;
	}

	/**
     * @return self
     */

	public function setPath(string $path): self{
		$this->path = $path;
        return $this;
    }
}