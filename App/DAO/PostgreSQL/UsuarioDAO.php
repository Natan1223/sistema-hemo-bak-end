<?php

namespace App\DAO\PostgreSQL;

use App\DAO\PostgreSQL\Conexao;
use App\Models\PostgreSQL\UsuarioModel;

final class UsuarioDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct(); 
    }

    public function cadastrarUsuario(UsuarioModel $usuario): array
    {

        return $response;
    }

    public function listarUsuarios(UsuarioModel $usuario): array
    {
 
        return $response;
    }

    public function atualizarDadosUsuario(UsuarioModel $usuario): array
    {

        return $response;
    }

    public function atualizarSenha(UsuarioModel $usuario): array
    {

        return $response;
    }

}