<?php

namespace App\Models\PostgreSQL;

final class TokenModel
{ 
    private $idToken;
    private $idUsuario;
    private $token;
    private $refreshToken;
    private $dataExpira;


    /**
     * Get the value of idToken
     */ 
    public function getIdToken(): int
    {
        return $this->idToken;
    }

    /**
     * Set the value of idToken
     *
     * @return  self
     */ 
    public function setIdToken($idToken): TokenModel
    {
        $this->idToken = $idToken;

        return $this;
    }

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
    public function setIdUsuario($idUsuario): TokenModel
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token): TokenModel
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of refreshToken
     */ 
    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    /**
     * Set the value of refreshToken
     *
     * @return  self
     */ 
    public function setRefreshToken($refreshToken): TokenModel
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * Get the value of dataExpira
     */ 
    public function getDataExpira(): string
    {
        return $this->dataExpira;
    }

    /**
     * Set the value of dataExpira
     *
     * @return  self
     */ 
    public function setDataExpira($dataExpira): TokenModel
    {
        $this->dataExpira = $dataExpira;

        return $this;
    }
}