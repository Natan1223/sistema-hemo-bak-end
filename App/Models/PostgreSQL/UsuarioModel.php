<?php

namespace App\Models\PostgreSQL;

final class UsuarioModel
{ 
    private $idUsuario;
    private $idPessoa;
    private $login;
    private $senha;
    private $ativo;

    /**
     * Get the value of idUsuario
     */ 
    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    /**
     * Set the value of idUsuario
     *
     * @return  self
     */ 
    public function setIdUsuario($idUsuario): UsuarioModel
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get the value of idPessoa
     */ 
    public function getIdPessoa(): int
    {
        return $this->idPessoa;
    }

    /**
     * Set the value of idPessoa
     *
     * @return  self
     */ 
    public function setIdPessoa($idPessoa): UsuarioModel
    {
        $this->idPessoa = $idPessoa;

        return $this;
    }

    /**
     * Get the value of login
     */ 
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin($login): UsuarioModel
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get the value of senha
     */ 
    public function getSenha(): string
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     *
     * @return  self
     */ 
    public function setSenha($senha): UsuarioModel
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get the value of ativo
     */ 
    public function getAtivo(): string
    {
        return $this->ativo;
    }

    /**
     * Set the value of ativo
     *
     * @return  self
     */ 
    public function setAtivo($ativo): UsuarioModel
    {
        $this->ativo = $ativo;

        return $this;
    }
}