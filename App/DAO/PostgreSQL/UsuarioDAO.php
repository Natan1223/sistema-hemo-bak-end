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

    public function usuarioLogin(string $usuario): ?UsuarioModel
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            u.idusuario,
                            u.login,
                            u.senha
                        FROM administracao.usuario u
                        WHERE u.login = :usuario
            ');
        $statement->bindParam('usuario', $usuario);
        $statement->execute();
        $usuarios = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(count($usuarios) === 0)
            return null;
        
        $usuario = new UsuarioModel();
        $usuario->setIdUsuario($usuarios[0]['idusuario'])
                ->setLogin($usuarios[0]['login'])
                ->setSenha($usuarios[0]['senha']);

        return $usuario;
    }

}