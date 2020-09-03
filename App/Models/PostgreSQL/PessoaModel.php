<?php

namespace App\Models\PostgreSQL;

class PessoaModel
{
	/**
     * @var int
     */
	private $idPessoa;
	/**
     * @var int
     */
	private $naturalidade;
	/**
     * @var string
     */
	private $nome;
	/**
     * @var string
     */
	private $dataNascimento;
	/**
     * @var string
     */
	private $sexo;
	/**
     * @var string
     */
	private $cpf;
	/**
     * @var string
     */
	private $nomeMae;
	/**
     * @var string
     */
	private $email;
	/**
     * @var string
     */
	private $telefone1;
	/**
     * @var string
     */
	private $telefone2;

	/**
     * @return int
    */

    public function getIdPessoa(): int {
		return $this->idPessoa;
	}

	/**
     * @param int $idPessoa
     * @return self
     */

	public function setIdPessoa(int $idPessoa): self {
		$this->idPessoa = $idPessoa;
        return $this;
	}

	/**
     * @return int
    */

	public function getNaturalidade(): int {
		return $this->naturalidade;
	}

	/**
     * @param int $naturalidade
     * @return self
     */

	public function setNaturalidade(int $naturalidade): self{
		$this->naturalidade = $naturalidade;
        return $this;
	}

	/**
     * @return string
    */

	public function getNome(): string {
		return $this->nome;
	}

	/**
     * @param int $nome
     * @return self
     */

	public function setNome(string $nome): self{
		$this->nome = $nome;
        return $this;
	}

	/**
     * @return string
	*/
	
	public function getDataNascimento(): string {
		return $this->dataNascimento;
	}

	/**
     * @param int $dataNascimento
     * @return self
     */

	public function setDataNascimento(string $dataNascimento): self {
		$this->dataNascimento = $dataNascimento;
        return $this;
	}

	/**
     * @return string
	*/
	
	public function getSexo(): string {
		return $this->sexo;
	}

	/**
     * @param int $sexo
     * @return self
     */

	public function setSexo(string $sexo): self {
		$this->sexo = $sexo;
        return $this;
	}

	/**
     * @return string
    */

	public function getCpf(): string {
		return $this->cpf;
	}

	/**
     * @param int $cpf
     * @return self
     */

	public function setCpf(string $cpf) : self {
		$this->cpf = $cpf;
        return $this;
	}

	/**
     * @return string
    */

	public function getNomeMae(): string {
		return $this->nomeMae;
	}

	/**
     * @param int $nomeMae
     * @return self
     */

	public function setNomeMae(string $nomeMae) : self {
		$this->nomeMae = $nomeMae;
        return $this;
	}

	/**
     * @return string
    */

	public function getEmail(): string {
		return $this->email;
	}

	/**
     * @param int $email
     * @return self
     */

	public function setEmail(string $email) : self {
		$this->email = $email;
        return $this;
	}

	/**
     * @return string
    */

	public function getTelefone1(): string {
		return $this->telefone1;
	}

	/**
     * @param int $telefone1
     * @return self
     */

	public function setTelefone1(string $telefone1) : self {
		$this->telefone1 = $telefone1;
        return $this;
	}

	/**
     * @return string
    */

	public function getTelefone2(): string {
		return $this->telefone2;
	}

	/**
     * @param int $telefone2
     * @return self
     */

	public function setTelefone2(string $telefone2) : self {
		$this->telefone2 = $telefone2;
        return $this;
	}

}