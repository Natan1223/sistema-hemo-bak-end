<?php

namespace App\Models\PostgreSQL;

final class CidadeModel
{
	private $idCidade;
	private $descricao;

    public function getIdCidade(): int {
		return $this->idCidade;
	}

	/**
     * @return self
     */

	public function setIdCidade(int $idCidade): self {
		$this->idCidade = $idCidade;
        return $this;
	}

	public function getDescricao(): string {
		return $this->descricao;
	}

	/**
     * @return self
     */

	public function setDescricao(int $descricao): self{
		$this->descricao = $descricao;
        return $this;
	}

	
}