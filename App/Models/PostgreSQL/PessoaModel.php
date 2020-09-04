<?php

namespace App\Models\PostgreSQL;

class PessoaModel
{
	private $idPessoa;
	private $naturalidade;
	private $nome;
	private $dataNascimento;
	private $sexo;
	private $cpf;
	private $nomeMae;
	private $email;
	private $telefone1;
	private $telefone2;

    public function getIdPessoa(): int {
		return $this->idPessoa;
	}

	/**
     * @return self
     */

	public function setIdPessoa(int $idPessoa): self {
		$this->idPessoa = $idPessoa;
        return $this;
	}

	public function getNaturalidade(): int {
		return $this->naturalidade;
	}

	/**
     * @return self
     */

	public function setNaturalidade(int $naturalidade): self{
		$this->naturalidade = $naturalidade;
        return $this;
	}

	public function getNome(): string {
		return $this->nome;
	}

	/**
     * @return self
     */

	public function setNome(string $nome): self{
		$this->nome = $nome;
        return $this;
	}

	public function getDataNascimento(): string {
		return $this->dataNascimento;
	}

	/**
     * @return self
     */

	public function setDataNascimento(string $dataNascimento): self {
		$this->dataNascimento = $dataNascimento;
        return $this;
	}
	
	public function getSexo(): string {
		return $this->sexo;
	}

	/**
     * @return self
     */

	public function setSexo(string $sexo): self {
		$this->sexo = $sexo;
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

	public function getNomeMae(): string {
		return $this->nomeMae;
	}

	/**
     * @return self
     */

	public function setNomeMae(string $nomeMae) : self {
		$this->nomeMae = $nomeMae;
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

	public function getTelefone1(): string {
		return $this->telefone1;
	}

	/**
     * @return self
     */

	public function setTelefone1(string $telefone1) : self {
		$this->telefone1 = $telefone1;
        return $this;
	}

	public function getTelefone2(): string {
		return $this->telefone2;
	}

	/**
     * @return self
     */

	public function setTelefone2(string $telefone2) : self {
		$this->telefone2 = $telefone2;
        return $this;
	}

}