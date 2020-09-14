<?php

namespace App\Models\PostgreSQL;

class PersonModel
{
	private $idPerson;
	private $naturalness;
	private $name;
	private $birth;
	private $gender;
	private $cpf;
	private $motherName;
	private $email;
	private $phone1;
	private $phone2;

    public function getIdPerson(): int {
		return $this->idPerson;
	}

	/**
     * @return self
     */

	public function setIdPerson(int $idPerson): self {
		$this->idPerson = $idPerson;
        return $this;
	}

	public function getNaturalness(): int {
		return $this->naturalness;
	}

	/**
     * @return self
     */

	public function setNaturalness(int $naturalness): self{
		$this->naturalness = $naturalness;
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

	public function getBirth(): string {
		return $this->birth;
	}

	/**
     * @return self
     */

	public function setBirth(string $birth): self {
		$this->birth = $birth;
        return $this;
	}
	
	public function getGender(): string {
		return $this->gender;
	}

	/**
     * @return self
     */

	public function setGender(string $gender): self {
		$this->gender = $gender;
        return $this;
	}

	public function getCpf(): string {
		return $this->cpf;
	}

	/**
     * @return self
     */

	public function setCpf(string $cpf) : self {
		$this->cpf = $cpf;
        return $this;
	}

	public function getMotherName(): string {
		return $this->motherName;
	}

	/**
     * @return self
     */

	public function setMotherName(string $motherName) : self {
		$this->motherName = $motherName;
        return $this;
	}

	public function getEmail(): string {
		return $this->email;
	}

	/**
     * @return self
     */

	public function setEmail(string $email) : self {
		$this->email = $email;
        return $this;
	}

	public function getPhone1(): string {
		return $this->phone1;
	}

	/**
     * @return self
     */

	public function setPhone1(string $phone1) : self {
		$this->phone1 = $phone1;
        return $this;
	}

	public function getPhone2(): string {
		return $this->phone2;
	}

	/**
     * @return self
     */

	public function setPhone2(string $phone2) : self {
		$this->phone2 = $phone2;
        return $this;
	}

}