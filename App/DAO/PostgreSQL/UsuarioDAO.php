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

    public function cadastrarUsuario(UsuarioModel $usuario)
    {
        $statement = $this->pdo
            ->prepare(' INSERT INTO 
                        administracao.usuario (
                            idpessoa, 
                            login, 
                            senha, 
                            ativo
                        ) VALUES (
                            :idpessoa,
                            :login,
                            :senha,
                            :ativo   
                        );
            ');
        $statement->execute([
            'idpessoa'=>$usuario->getIdPessoa(),
            'login'=>$usuario->getLogin(),
            'senha'=>$usuario->getSenha(),
            'ativo' =>$usuario->getAtivo()
        ]);

        $idUsuario =  $this->pdo->lastInsertId();
        
        return $idUsuario;
 
    }

    public function listarUsuarios(): array
    {
        $statement = $this->pdo
            ->prepare(' SELECT 
                            idusuario,
                            login,
                            ativo
                        FROM administracao.usuario
                        ORDER BY idusuario,ativo
            ');
        $statement->execute();
        $response = $statement->fetchAll(\PDO::FETCH_ASSOC);
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
        $usuario
            ->setIdUsuario($usuarios[0]['idusuario'])
            ->setLogin($usuarios[0]['login'])
            ->setSenha($usuarios[0]['senha']);

        return $usuario;
    }

}